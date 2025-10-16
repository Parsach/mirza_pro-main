<?php
ini_set('error_log', 'error_log');

require_once '../config.php';
require_once '../Marzban.php';
require_once '../function.php';
require_once '../panels.php';
$ManagePanel = new ManagePanel();
$url = $_SERVER['REQUEST_URI'];
$parts = explode("/sub/", $url);
$link = $parts[1];
header('Content-Type: text/plain; charset=utf-8');
$token = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
try {
if(!isset($token)){
    echo "ERROR!";
}
$nameloc = select("invoice","*","id_invoice",$token,"select");
$DataUserOut = $ManagePanel->DataUser($nameloc['Service_location'],$nameloc['username']);
$config = "";
foreach ($DataUserOut['links'] as $Links){
    $config .= $Links."\r\r";
}
echo $config;
} catch (Exception $e) {
    echo "Error!";
}
