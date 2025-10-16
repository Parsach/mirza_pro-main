<?php
session_start();
require_once '../config.php'; 
function update($table, $field, $newValue, $whereField = null, $whereValue = null) {
    global $pdo,$user;

    if ($whereField !== null) {
        $stmt = $pdo->prepare("SELECT $field FROM $table WHERE $whereField = ? FOR UPDATE");
        $stmt->execute([$whereValue]);
        $currentValue = $stmt->fetchColumn();
        $stmt = $pdo->prepare("UPDATE $table SET $field = ? WHERE $whereField = ?");
        $stmt->execute([$newValue, $whereValue]);
    } else {
        $stmt = $pdo->prepare("UPDATE $table SET $field = ?");
        $stmt->execute([$newValue]);
    }
    $date = date("Y-m-d");
    $logss = "{$table}_{$field}_{$newValue}_{$whereField}_{$whereValue}_{$user['step']}_$date";
    if($field != "message_count" || $field != "last_message_time"){
        file_put_contents('log.txt',"\n".$logss,FILE_APPEND);
    }
}

    $query = $pdo->prepare("SELECT * FROM admin WHERE username=:username");
    $query->bindParam("username", $_SESSION["user"], PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $query = $pdo->prepare("SELECT * FROM x_ui");
    $query->execute();
    $resultpanel = $query->fetchAll();
if( !isset($_SESSION["user"]) || !$result ){
    header('Location: login.php');
    return;
}
    if($_GET['action'] == "save"){
        update("x_ui", "setting", $_POST['settings'], "codepanel", $_POST['namepanel']);
        header('Location: seeting_x_ui.php');
    }
$namepanel = htmlspecialchars($_POST['namepanel'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title>پنل مدیریت ربات میرزا</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" class="">
  <?php include("header.php");
?>
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    <aside class="col-lg-12">
                    <?php
                        if($_GET['action'] != "change"){?>
                            <section class="panel">
                            <div class="panel-body bio-graph-info">
                                <h1>در این صفحه می توانید تعیین کنید  چه تنظیمات برای کانفیگ ساخته شود در پنل x-ui</h1>
                                <form class="form-horizontal" role="form" method = "POST" action = "seeting_x_ui.php?action=change">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">نام پنل</label>
                                        <div class="col-lg-7">
                                            <select required style ="padding:0;" name = "namepanel" class="form-control input-sm m-bot15">
                                                  <option value="">انتخاب نشده</option>
                                                <?php
                                                if(count($resultpanel)>=0){
                                                foreach($resultpanel as $panel){
                                                $query = $pdo->prepare("SELECT * FROM marzban_panel WHERE code_panel=:code_panel");
                                                $query->bindParam("code_panel", $panel['codepanel'], PDO::PARAM_STR);
                                                $query->execute();
                                                $namepanel = $query->fetch(PDO::FETCH_ASSOC);
                                                echo "<option value = \"{$panel['codepanel']}\">{$namepanel['name_panel']}</option>";
                                                }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                            <button type="submit" class="btn btn-success">تغییر تنظیمات</button>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <?php
                        }
                        ?>
                        <?php
                        if($_GET['action'] == "change"){?>
                        <section class="panel">
                            <div class="panel-body bio-graph-info">
                                <h1>در این صفحه می توانید تعیین کنید  چه تنظیمات برای کانفیگ ساخته شود در پنل x-ui</h1>
                                <label class="col-lg-2 control-label">تنظیمات آماده</label>
                                <select style = 'width:400px; margin-bottom:10px' id="mySelect" onchange="updateTextarea()">
                                    <option value="">انتخاب کنید...</option>
                                    <option value="tcp_http">tcp + http</option>
                                    <option value="ws_tls">ws + tls</option>
                                    <option value="گزینه ۳">گزینه ۳</option>
</select>
                                <form class="form-horizontal" role="form" method = "POST" action = "seeting_x_ui.php?action=save">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">تنظیمات</label>
                                        <div class="col-lg-10">
                                            <textarea id="settings" style = "direction:ltr;" name="settings" id="setting" class="form-control" cols="50" rows="25"><?php
                                                $query = $pdo->prepare("SELECT * FROM x_ui WHERE codepanel=:codepanel");
                                                $query->bindParam("codepanel", $namepanel, PDO::PARAM_STR);
                                                $query->execute();
                                                $getsetting = $query->fetch(PDO::FETCH_ASSOC);
                                                $data = json_decode($getsetting['setting']);
                                                echo json_encode($data, JSON_PRETTY_PRINT);
                                                ?>
                                           </textarea>
                                           <input name = "namepanel" type= "hidden" value = "<?php echo $namepanel?>">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button type="submit" class="btn btn-success">ذخیره</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <?php
                        }
                        ?>
                    </aside>
                </div>

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
</select>

<script>
  function updateTextarea() {
    var selectElement = document.getElementById("mySelect");
    var textareaElement = document.getElementById("settings");
    var selectedOption = selectElement.options[selectElement.selectedIndex].value;
    if (selectedOption === "tcp_http") {
        selectedOption = `{
  "network": "tcp",
  "security": "none",
  "externalProxy": [],
  "tcpSettings": {
    "acceptProxyProtocol": false,
    "header": {
      "type": "http",
      "request": {
        "version": "1.1",
        "method": "GET",
        "path": [
          "/"
        ],
        "headers": {
          "host": [
            "zula.ir"
          ]
        }
      },
      "response": {
        "version": "1.1",
        "status": "200",
        "reason": "OK",
        "headers": {}
      }
    }
  }
}`;
    } else if (selectedOption == "") {
        selectedOption =  '{
  "network": "ws",
  "security": "none",
  "externalProxy": [],
  "wsSettings": {
    "acceptProxyProtocol": false,
    "path": "/",
    "host": "",
    "headers": {}
  }
}';
}   
 else if (selectedOption == "ws_tls") {
        selectedOption = `{
  "network": "ws",
  "security": "tls",
  "externalProxy": [],
  "tlsSettings": {
    "serverName": "sni.com",
    "minVersion": "1.2",
    "maxVersion": "1.3",
    "cipherSuites": "",
    "rejectUnknownSni": true,
    "certificates": [
      {
        "certificateFile": "",
        "keyFile": "",
        "ocspStapling": 3600
      }
    ],
    "alpn": [
      "h2",
      "http/1.1"
    ],
    "settings": {
      "allowInsecure": true,
      "fingerprint": ""
    }
  },
  "wsSettings": {
    "acceptProxyProtocol": false,
    "path": "/",
    "headers": {}
  }
}`;
}   

    textareaElement.value = selectedOption;
  }
</script>

</body>
</html>
