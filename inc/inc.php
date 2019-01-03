<?php
/**
 * 全能收款码（三码合一收款）
 * V1.0
 * liukuan
 */
require_once("config.php");//引用配置文件
date_default_timezone_set("PRC");
session_start();
define("ROOT_PATH",str_replace('/inc/inc.php','/',str_replace("\\",'/',__FILE__)));
require(ROOT_PATH."inc/function.php");
require(ROOT_PATH."inc/Mysql.class.php");
$db= new mysql($host,$user,$password,$name,'utf8');
$conn=mysql_connect($host,$user,$password);//连接MySQL
$db1=@mysql_select_db($name,$conn) or die ("连接数据库失败");//数据库
error_reporting(E_ALL ^ E_NOTICE);
?>