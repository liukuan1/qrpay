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

if (@$_GET['type'] == 'qrcode') {
    if (@$_GET['text']) {
        include "class/phpqrcode.php";
        QRcode::png($_GET['text'], false, 'L', '10', '1');
        die;
    }
}elseif (@$_GET['type'] == 'id') {
    if (@$_GET['payid']) {
        $result = $db->getRow("SELECT * FROM qr_pay WHERE id = '{$_GET['payid']}' AND isDelete = 0");
        if ($result) {
            $db->query("UPDATE qr_pay set count = count + 1 WHERE id = '{$result['id']}'");
            //echo $result['qq_pay'] . " " . $result['ali_pay'] . " " . $result['wx_pay'] . " " . "<br />";
            $alipay = $result['ali_pay'];
            $wxpay = $result['wx_pay'];
            $qqpay = $result['qq_pay'];
            $nickname = $result['nickname'];
        } else {
            echo 'no payid';
            //$alipay = "https://qr.alipay.com/apr0vh05pw5ui7lae4";
            //$wxpay = "https://wx.tenpay.com/f2f?t=AQAAAHphXG0ddHZM6pZVSlllH%2F8%3D";
            //$qqpay = "https://i.qianbao.qq.com/wallet/sqrcode.htm?m=tenpay&a=1&u=250502876&ac=10AB2118A92485678C4AA7283F143BE4B0315F26C1685FD0148CB5B804064456&n=%E9%99%8C%E6%99%B4&f=wallet";
            //$nickname = "";
            die;
        }

    } else {
        echo 'no payid';
        //$alipay = "https://qr.alipay.com/apr0vh05pw5ui7lae4";
        //$wxpay = "https://wx.tenpay.com/f2f?t=AQAAAHphXG0ddHZM6pZVSlllH%2F8%3D";
        //$qqpay = "https://i.qianbao.qq.com/wallet/sqrcode.htm?m=tenpay&a=1&u=250502876&ac=10AB2118A92485678C4AA7283F143BE4B0315F26C1685FD0148CB5B804064456&n=%E9%99%8C%E6%99%B4&f=wallet";
        //$nickname = "";
        die;
    }
} else {
    echo 'error~';
    die;
}

$url   = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$urlqr = 'http://' . $_SERVER['HTTP_HOST'] . '/qrcode.php?type=qrcode&text=';
$ua    = $_SERVER['HTTP_USER_AGENT'];
if (strpos($ua, 'Alipay')) {
    //支付宝
    $config = array(
        "url" => $alipay,
        "new" => 0,
    );
} elseif (strpos($ua, 'MicroMessenger')) {
    //微信
    $config = array(
        "url"      => $wxpay,
        "nickname" => $nickname,
        "text"     => "长按二维码付款给 " . $nickname . " !",
        "col"      => "#44b549",
        "new"      => 1,
    );
} elseif (strpos($ua, 'QQ/')) {
    //QQ
    $config = array(
        "url"      => $qqpay,
        "nickname" => $nickname,
        "text"     => "长按二维码付款给 " . $nickname . " !",
        "col"      => "#0099de",
        "new"      => 1,
    );
} else {
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,"http://s.dopan.net/create.php");
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $data=array('url'=>$url);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    $strRes=curl_exec($ch);
    curl_close($ch);
    $arrResponse=json_decode($strRes,true);
    if($arrResponse['success']==0)
    {
        if ("对不起，该网址已经存在" == $arrResponse['message']) {
            //echo $arrResponse['transurl']."\n";
            $surl = $arrResponse['transurl'];
        } else {
            /**错误处理*/
            echo $arrResponse['message']."\n";
        }
    } else {
        //echo $arrResponse['transurl']."\n";
        $surl = $arrResponse['transurl'];
    }

    //普通打开页面
    $config = array(
        "url"      => $surl,
        "nickname" => $nickname,
        "text"     => "支付宝、微信、QQ<br>扫码付款给 " . $nickname . " !",
        "col"      => "#2d2d2d",
        "new"      => 1,
    );
}

if (!$config['new'])
    header("Location:" . $config['url']);

$config['img'] = @$config['img'] ? $config['img'] : $urlqr . urlencode($config['url']) . "&nickname=" . urlencode($config['nickname']);
?>
<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <title>全能收款码</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="//cdn.bootcss.com/amazeui/2.7.2/css/amazeui.min.css">
</head>
<body>
    <style type="text/css">
        body{background:#fff;}
        .box{width:100%;height:100%;overflow:hidden;position:fixed;top:0;left:0;}
        .bg-f4{background-color:#f4f4f4;}
        .img{max-width:100%;max-height:100%;}
        ._title{height:80px;padding:10px 0;}
        ._qr{height:100%;background:<?php echo $config['col'] ?>;}
        ._qr img{width:80%;margin-top:50px;border-radius:10px;}
        ._bot{width:80%;background:#fff;margin:10px auto;padding:10px 5px;}
        ._copy{position:fixed;width:100%;bottom:0;left:0;color:#4169E1;padding:10px 0;font-size:10pt;}
    </style>
    <div class="am-g box">
        <div class="am-u-sm-12 am-u-md-6 am-u-lg-3 am-u-sm-centered bg-f4 am-text-center _title">
            <img src="img/icon/ali.png" class="img" alt="支付宝">
            <img src="img/icon/wx.png" class="img" alt="微信">
            <img src="img/icon/qq.png" class="img" alt="QQ">
            <!-- <img src="img/icon/jd.png" class="img" alt="京东金融"> -->
        </div>
        <div class="am-u-sm-12 am-u-md-6 am-u-lg-3 am-u-sm-centered am-text-center _qr">
            <img src="<?php echo $config['img'] ?>" class="img">
            <div class="am-text-center _bot">
                <?php echo $config['text'] ?>
            </div>
            <div class="am-text-center">
                <img src="img/x.jpg" class="img">
            </div>
        </div>
        <div class="am-text-center _copy">powered by 陌晴</div>
    </div>
</body>
</html>
