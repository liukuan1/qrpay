<?php
/**
 * 全能收款码（三码合一收款）
 * V1.0
 * liukuan
 */
define("IN_QKWEB",true);
require_once("inc/inc.php");
error_reporting(E_ALL ^ E_NOTICE);

require_once("inc/tongji.php");

if (isset($_GET['alipay']) && isset($_GET['wxpay']) || isset($_GET['qqpay']) || isset($_GET['nickname'])) {
    
    $result = $db->getRow("SELECT * FROM qr_pay WHERE ali_pay = '{$_GET['alipay']}' AND wx_pay = '{$_GET['wxpay']}' AND qq_pay = '{$_GET['qqpay']}' AND nickname = '{$_GET['nickname']}' AND isDelete = 0");
    if(!$result) {
        $id = md5(uniqid());
        $db->query("INSERT INTO qr_pay (id, ali_pay, wx_pay, qq_pay, nickname) VALUES ('{$id}', '{$_GET['alipay']}', '{$_GET['wxpay']}', '{$_GET['qqpay']}', '{$_GET['nickname']}' )");
    } else {
        $id = $result['id'];
    }
    $qrurl = $siteHost . "/qrcode.php?type=id&payid=" . $id;
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,"http://s.dopan.net/create.php");
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $data=array('url'=>$qrurl);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    $strRes=curl_exec($ch);
    curl_close($ch);
    $arrResponse=json_decode($strRes,true);
    if($arrResponse['success']==0)
    {
        if ("对不起，该网址已经存在" == $arrResponse['message']) {
            //echo $arrResponse['transurl']."\n";
            include "class/phpqrcode.php";
            QRcode::png($arrResponse['transurl'], false, 'L', '10', '1');
            die;
        } else {
            /**错误处理*/
            echo $arrResponse['message']."\n";
        }
    } else {
        //echo $arrResponse['transurl']."\n";
        include "class/phpqrcode.php";
        QRcode::png($arrResponse['transurl'], false, 'L', '10', '1');
        die;
    }
    
} else {
    echo 'param is null';
    die;
}
?>