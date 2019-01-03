<?php
/**
 * 全能收款码（三码合一收款）
 * V1.0
 * liukuan
 */
define("IN_QKWEB",true);
require_once("inc.php");
error_reporting(E_ALL ^ E_NOTICE);
$ip = getip();
//log
$db->query("INSERT INTO qr_log (ip, driver, content) VALUES ('{$ip}', '{$_SERVER['HTTP_USER_AGENT']}', '{$_SERVER['REQUEST_URI']}' )");

function getip() {
    if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP'); 
    }
    elseif (getenv('HTTP_X_FORWARDED_FOR')) { //获取客户端用代理服务器访问时的真实ip 地址
            $ip = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_X_FORWARDED')) { 
            $ip = getenv('HTTP_X_FORWARDED');
    }
    elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR'); 
    }
    elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
    }
    else {
            $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

?>