<?php
require_once 'config.php';
require_once 'request.php';
ini_set('error_log', 'error_log');

/**
 * Login to 3x-ui panel and get session cookie
 * @param string $code_panel Panel code from database
 * @return array Response with session cookie
 */
function panel_login_3xui($code_panel)
{
    $panel = select("marzban_panel", "*", "code_panel", $code_panel, "select");
    
    // Prepare login data
    $loginData = array(
        'username' => $panel['username_panel'],
        'password' => $panel['password_panel']
    );
    
    // Add two-factor code if exists
    if (isset($panel['twoFactorCode']) && !empty($panel['twoFactorCode'])) {
        $loginData['twoFactorCode'] = $panel['twoFactorCode'];
    }
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => rtrim($panel['url_panel'], '/') . '/login/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT_MS => 4000,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($loginData),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        CURLOPT_COOKIEJAR => '3xui_cookie.txt',
    ));
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if (curl_error($curl)) {
        $error = array(
            'error' => curl_error($curl),
            'status' => 500
        );
        curl_close($curl);
        return $error;
    }
    
    curl_close($curl);
    
    // Parse response
    $responseData = json_decode($response, true);
    
    if ($httpCode == 200 && isset($responseData['success']) && $responseData['success'] == true) {
        return array(
            'success' => true,
            'body' => $response
        );
    } else {
        return array(
            'success' => false,
            'error' => isset($responseData['msg']) ? $responseData['msg'] : 'Login failed',
            'status' => $httpCode
        );
    }
}

/**
 * Login to 3x-ui panel with session management
 * @param string $code_panel Panel code
 * @param bool $verify Verify session validity
 * @return array Login response
 */
function login_3xui($code_panel, $verify = true)
{
    $panel = select("marzban_panel", "*", "code_panel", $code_panel, "select");
    
    // Check if we have a valid session
    if ($panel['datelogin'] != null && $verify) {
        $date = json_decode($panel['datelogin'], true);
        if (isset($date['time'])) {
            $timecurrent = time();
            $start_date = time() - strtotime($date['time']);
            // Session valid for 5 hours (18000 seconds)
            if ($start_date <= 18000) {
                if (isset($date['cookie_content']) && file_exists('3xui_cookie.txt')) {
                    file_put_contents('3xui_cookie.txt', $date['cookie_content']);
                    return array('success' => true);
                }
            }
        }
    }
    
    // Login and get new session
    $response = panel_login_3xui($panel['code_panel']);
    
    if ($response['success']) {
        $time = date('Y/m/d H:i:s');
        $cookieContent = file_exists('3xui_cookie.txt') ? file_get_contents('3xui_cookie.txt') : '';
        $data = json_encode(array(
            'time' => $time,
            'cookie_content' => $cookieContent
        ));
        update("marzban_panel", "datelogin", $data, 'name_panel', $panel['name_panel']);
    }
    
    return $response;
}

/**
 * Get list of all inbounds
 * @param string $namepanel Panel name
 * @return array Inbounds list
 */
function getInbounds_3xui($namepanel)
{
    $panel = select("marzban_panel", "*", "name_panel", $namepanel, "select");
    $login = login_3xui($panel['code_panel']);
    
    if (!$login['success']) {
        return $login;
    }
    
    $url = rtrim($panel['url_panel'], '/') . '/panel/api/inbounds/list';
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );
    
    $req = new CurlRequest($url);
    $req->setHeaders($headers);
    $req->setCookie('3xui_cookie.txt');
    $response = $req->get();
    
    return $response;
}

/**
 * Get specific inbound details
 * @param string $namepanel Panel name
 * @param int $inboundId Inbound ID
 * @return array Inbound details
 */
function getInbound_3xui($namepanel, $inboundId)
{
    $panel = select("marzban_panel", "*", "name_panel", $namepanel, "select");
    $login = login_3xui($panel['code_panel']);
    
    if (!$login['success']) {
        return $login;
    }
    
    $url = rtrim($panel['url_panel'], '/') . '/panel/api/inbounds/get/' . $inboundId;
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );
    
    $req = new CurlRequest($url);
    $req->setHeaders($headers);
    $req->setCookie('3xui_cookie.txt');
    $response = $req->get();
    
    return $response;
}

/**
 * Add client to 3x-ui inbound
 * @param string $namepanel Panel name
 * @param string $username Client username/email
 * @param int $expire Expiry timestamp
 * @param int $total Total traffic in bytes
 * @param string $uuid Client UUID
 * @param string $flow Flow type (empty for most cases)
 * @param string $subId Subscription ID
 * @param int $inboundId Inbound ID
 * @param string $name_product Product name
 * @param string $note Additional notes
 * @return array Response
 */
function addClient_3xui($namepanel, $username, $expire, $total, $uuid, $flow, $subId, $inboundId, $name_product, $note = "")
{
    $panel = select("marzban_panel", "*", "name_panel", $namepanel, "select");
    $login = login_3xui($panel['code_panel']);
    
    if (!$login['success']) {
        return $login;
    }
    
    // Get current inbound details first
    $inboundDetails = getInbound_3xui($namepanel, $inboundId);
    if ($inboundDetails['status'] != 200) {
        return array(
            'status' => 500,
            'error' => 'Failed to get inbound details'
        );
    }
    
    $inboundData = json_decode($inboundDetails['body'], true);
    if (!$inboundData['success']) {
        return array(
            'status' => 500,
            'error' => $inboundData['msg']
        );
    }
    
    $inbound = $inboundData['obj'];
    $settings = json_decode($inbound['settings'], true);
    
    // Calculate expiry time
    $expiryTime = 0;
    if ($expire != 0) {
        if ($panel['conecton'] == "onconecton" || ($name_product == "usertest" && $panel['on_hold_test'] == "1")) {
            $timelast = $expire - time();
            $expiryTime = time() * 1000 + ($timelast * 1000);
        } else {
            $expiryTime = $expire * 1000;
        }
    }
    
    // Add new client to existing clients
    $newClient = array(
        "id" => $uuid,
        "flow" => $flow,
        "email" => $username,
        "limitIp" => 0,
        "totalGB" => $total,
        "expiryTime" => $expiryTime,
        "enable" => true,
        "tgId" => "",
        "subId" => $subId,
        "comment" => $note,
        "reset" => 0,
        "created_at" => time() * 1000,
        "updated_at" => time() * 1000
    );
    
    // Add client to settings
    if (!isset($settings['clients'])) {
        $settings['clients'] = array();
    }
    $settings['clients'][] = $newClient;
    
    // Prepare update data
    $updateData = array(
        "id" => intval($inboundId),
        "up" => $inbound['up'],
        "down" => $inbound['down'],
        "total" => $inbound['total'],
        "remark" => $inbound['remark'],
        "enable" => $inbound['enable'],
        "expiryTime" => $inbound['expiryTime'],
        "listen" => $inbound['listen'],
        "port" => $inbound['port'],
        "protocol" => $inbound['protocol'],
        "settings" => json_encode($settings),
        "streamSettings" => $inbound['streamSettings'],
        "sniffing" => $inbound['sniffing']
    );
    
    // Update inbound with new client
    $url = rtrim($panel['url_panel'], '/') . '/panel/api/inbounds/update/' . $inboundId;
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );
    
    $req = new CurlRequest($url);
    $req->setHeaders($headers);
    $req->setCookie('3xui_cookie.txt');
    $response = $req->post(json_encode($updateData));
    
    // Clean up cookie file
    if (file_exists('3xui_cookie.txt')) {
        unlink('3xui_cookie.txt');
    }
    
    return $response;
}

/**
 * Update client in 3x-ui
 * @param string $namepanel Panel name
 * @param string $uuid Client UUID
 * @param array $config Update configuration
 * @return array Response
 */
function updateClient_3xui($namepanel, $uuid, array $config)
{
    $panel = select("marzban_panel", "*", "name_panel", $namepanel, "select");
    $login = login_3xui($panel['code_panel']);
    
    if (!$login['success']) {
        return $login;
    }
    
    // Find the client in inbounds
    $inboundsList = getInbounds_3xui($namepanel);
    if ($inboundsList['status'] != 200) {
        return array(
            'status' => 500,
            'error' => 'Failed to get inbounds list'
        );
    }
    
    $inboundsData = json_decode($inboundsList['body'], true);
    if (!$inboundsData['success']) {
        return array(
            'status' => 500,
            'error' => $inboundsData['msg']
        );
    }
    
    $targetInbound = null;
    $targetClientIndex = -1;
    
    // Find the inbound and client
    foreach ($inboundsData['obj'] as $inbound) {
        $settings = json_decode($inbound['settings'], true);
        if (isset($settings['clients'])) {
            foreach ($settings['clients'] as $index => $client) {
                if ($client['id'] == $uuid) {
                    $targetInbound = $inbound;
                    $targetClientIndex = $index;
                    break 2;
                }
            }
        }
    }
    
    if ($targetInbound == null || $targetClientIndex == -1) {
        return array(
            'status' => 404,
            'error' => 'Client not found'
        );
    }
    
    $settings = json_decode($targetInbound['settings'], true);
    
    // Update client data
    foreach ($config as $key => $value) {
        if ($key == 'totalGB' || $key == 'expiryTime' || $key == 'enable' || $key == 'email' || $key == 'limitIp' || $key == 'reset') {
            $settings['clients'][$targetClientIndex][$key] = $value;
        }
    }
    
    $settings['clients'][$targetClientIndex]['updated_at'] = time() * 1000;
    
    // Prepare update data
    $updateData = array(
        "id" => intval($targetInbound['id']),
        "up" => $targetInbound['up'],
        "down" => $targetInbound['down'],
        "total" => $targetInbound['total'],
        "remark" => $targetInbound['remark'],
        "enable" => $targetInbound['enable'],
        "expiryTime" => $targetInbound['expiryTime'],
        "listen" => $targetInbound['listen'],
        "port" => $targetInbound['port'],
        "protocol" => $targetInbound['protocol'],
        "settings" => json_encode($settings),
        "streamSettings" => $targetInbound['streamSettings'],
        "sniffing" => $targetInbound['sniffing']
    );
    
    // Update inbound
    $url = rtrim($panel['url_panel'], '/') . '/panel/api/inbounds/update/' . $targetInbound['id'];
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );
    
    $req = new CurlRequest($url);
    $req->setHeaders($headers);
    $req->setCookie('3xui_cookie.txt');
    $response = $req->post(json_encode($updateData));
    
    // Clean up cookie file
    if (file_exists('3xui_cookie.txt')) {
        unlink('3xui_cookie.txt');
    }
    
    return $response;
}

/**
 * Delete client from 3x-ui
 * @param string $namepanel Panel name
 * @param string $uuid Client UUID
 * @return array Response
 */
function deleteClient_3xui($namepanel, $uuid)
{
    $panel = select("marzban_panel", "*", "name_panel", $namepanel, "select");
    $login = login_3xui($panel['code_panel']);
    
    if (!$login['success']) {
        return $login;
    }
    
    // Find the client in inbounds
    $inboundsList = getInbounds_3xui($namepanel);
    if ($inboundsList['status'] != 200) {
        return array(
            'status' => 500,
            'error' => 'Failed to get inbounds list'
        );
    }
    
    $inboundsData = json_decode($inboundsList['body'], true);
    if (!$inboundsData['success']) {
        return array(
            'status' => 500,
            'error' => $inboundsData['msg']
        );
    }
    
    $targetInbound = null;
    $targetClientIndex = -1;
    
    // Find the inbound and client
    foreach ($inboundsData['obj'] as $inbound) {
        $settings = json_decode($inbound['settings'], true);
        if (isset($settings['clients'])) {
            foreach ($settings['clients'] as $index => $client) {
                if ($client['id'] == $uuid) {
                    $targetInbound = $inbound;
                    $targetClientIndex = $index;
                    break 2;
                }
            }
        }
    }
    
    if ($targetInbound == null || $targetClientIndex == -1) {
        return array(
            'status' => 404,
            'error' => 'Client not found'
        );
    }
    
    $settings = json_decode($targetInbound['settings'], true);
    
    // Remove client from array
    array_splice($settings['clients'], $targetClientIndex, 1);
    
    // Prepare update data
    $updateData = array(
        "id" => intval($targetInbound['id']),
        "up" => $targetInbound['up'],
        "down" => $targetInbound['down'],
        "total" => $targetInbound['total'],
        "remark" => $targetInbound['remark'],
        "enable" => $targetInbound['enable'],
        "expiryTime" => $targetInbound['expiryTime'],
        "listen" => $targetInbound['listen'],
        "port" => $targetInbound['port'],
        "protocol" => $targetInbound['protocol'],
        "settings" => json_encode($settings),
        "streamSettings" => $targetInbound['streamSettings'],
        "sniffing" => $targetInbound['sniffing']
    );
    
    // Update inbound
    $url = rtrim($panel['url_panel'], '/') . '/panel/api/inbounds/update/' . $targetInbound['id'];
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );
    
    $req = new CurlRequest($url);
    $req->setHeaders($headers);
    $req->setCookie('3xui_cookie.txt');
    $response = $req->post(json_encode($updateData));
    
    // Clean up cookie file
    if (file_exists('3xui_cookie.txt')) {
        unlink('3xui_cookie.txt');
    }
    
    return $response;
}

/**
 * Get client traffic information
 * @param string $namepanel Panel name
 * @param string $email Client email
 * @return array Client traffic info
 */
function getClientTraffic_3xui($namepanel, $email)
{
    $panel = select("marzban_panel", "*", "name_panel", $namepanel, "select");
    $login = login_3xui($panel['code_panel']);
    
    if (!$login['success']) {
        return $login;
    }
    
    $url = rtrim($panel['url_panel'], '/') . '/panel/api/inbounds/getClientTraffics/' . urlencode($email);
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );
    
    $req = new CurlRequest($url);
    $req->setHeaders($headers);
    $req->setCookie('3xui_cookie.txt');
    $response = $req->get();
    
    // Clean up cookie file
    if (file_exists('3xui_cookie.txt')) {
        unlink('3xui_cookie.txt');
    }
    
    return $response;
}

/**
 * Reset client traffic
 * @param string $namepanel Panel name
 * @param string $email Client email
 * @param int $inboundId Inbound ID
 * @return array Response
 */
function resetClientTraffic_3xui($namepanel, $email, $inboundId)
{
    $panel = select("marzban_panel", "*", "name_panel", $namepanel, "select");
    $login = login_3xui($panel['code_panel']);
    
    if (!$login['success']) {
        return $login;
    }
    
    $url = rtrim($panel['url_panel'], '/') . '/' . $inboundId . '/resetClientTraffic/' . urlencode($email);
    
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
    );
    
    $req = new CurlRequest($url);
    $req->setHeaders($headers);
    $req->setCookie('3xui_cookie.txt');
    $response = $req->post('');
    
    // Clean up cookie file
    if (file_exists('3xui_cookie.txt')) {
        unlink('3xui_cookie.txt');
    }
    
    return $response;
}
