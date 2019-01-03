<?php
/**
 * 全能收款码（三码合一收款）
 * V1.0
 * liukuan
 */
define("IN_QKWEB",true);
require_once("inc/inc.php");
error_reporting(E_ALL ^ E_NOTICE);

$shengcheng = $db->getRow("SELECT count(*) AS count FROM qr_pay WHERE isDelete = 0");
$saomiao = $db->getRow("SELECT count(*) AS count FROM qr_log");
?>
<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>三合一收款码在线生成</title>
    <meta name="description" content="嘟嘟三合一收款码，打造最简便收款服务，支持微信、支付宝、QQ。" />
    <meta name="keywords" content="收款码,付款码,三合一收款码,五合一收款码,收款码美化,支付宝收款码" />
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <meta name="msapplication-TileColor" content="#0e90d2">
    <link href="https://lib.baomitu.com/amazeui/2.5.2/css/amazeui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/layui/css/layui.css"/>
    <link rel="stylesheet" href="static/css/app.css">
    <style type="text/css">
        input[type="text"]{text-align:center;font-size: 17px;border-radius: 20px;height: 45px;}
        a{color: #6d757a;}
        .footer {margin: 50px 0 0;padding: 20px 0 30px;line-height: 30px;text-align: center;color: #737573; border-top: 1px solid #e2e2e2;}
        .layui-nav{position: absolute;right: 0;top: 0;padding: 0;background: none;}
        .and{padding-top: 50px;text-align: center;}
        .and i{font-size: 100px;color: #0077ff;}
        p{ pointer-events: none; }
        .logo p{width: 150px;}
        @media screen and (max-width:993px) {
            .and{padding-top: 0px;}
            .layui-main{width: 100%;}
            .layui-nav{display: none;}
            .layui-carousel{display: none;}
        }
      </style>
</head>
<body>
<!--a href="https://github.com/takashiki/ourls">
    <img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png">
</a-->

<div class="fly-header layui-bg-cyan">
    <div class="layui-header header header-demo" summer="">
        <div class="layui-main">
            <div class="logo">
                <p style="font-size: 2em;">嘟嘟收款码</p>
            </div>
            <ul class="layui-nav">
                <li class="layui-nav-item">
                    <a href="http://pay.ilkhome.cn" target="_black">如果可以，请给作者一份打赏</a> 
                </li>
                    <li class="layui-nav-item">
                    <a href="https://github.com/liukuan1/qrpay" target="_black">GitHub</a> 
                </li>
                    <li class="layui-nav-item">
                    <a href="http://www.ilkhome.cn" target="_black">博客</a> 
                </li>
                    <li class="layui-nav-item">
                    <a href="tencent://message/?uin=250502876" target="_black">有问题点我</a> 
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="am-g">
    <div id="content" class="am-u-sm-centered">
        <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
            <legend>嘟嘟收款码 - 三合一收款码 - 在线生成</legend>
            <div class="layui-field-box">
                将微信收款码、QQ收款码和支付宝收款码合并为一个二维码，用户扫码后直接付款给商家，无需手续费。
            </div>
        </fieldset>
        <form class="am-form" id="shorturl">
            <div class="layui-col-md3" style="text-align: center;">
                <div class="am-form-group am-g-collapse">
                    <div class="am-form-group am-form-file">
                        <div class="layui-upload-drag upload">
                            <img src="img/icon/alipay.png" alt="选择支付宝收款码">
                        </div>
                        <input id="alipay" type="file" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="layui-col-md6">
                <div class="layui-row">
                    <div class="layui-col-md3 and"><i class="layui-icon">&#xe654;</i></div>
                    <div class="layui-col-md6" style="text-align: center;">
                        <div class="am-form-group am-g-collapse">
                            <div class="am-form-group am-form-file">
                                <div class="layui-upload-drag upload">
                                    <img src="img/icon/wxpay.png" alt="选择 微信 收款码">
                                </div>
                                <input id="wechat" type="file" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md3 and"><i class="layui-icon">&#xe654;</i></div>
                </div>
            </div>
            <div class="layui-col-md3" style="text-align: center;">
                <div class="am-form-group am-g-collapse">
                    <div class="am-form-group am-form-file">
                        <div class="layui-upload-drag upload">
                            <img src="img/icon/qqpay.png" alt="选择 ＱＱ 收款码">
                        </div>
                        <input id="qq" type="file" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="layui-row" style="margin-top: 20px;">
                <div class="layui-col-md12" style="text-align: center;">
                    <div class="layui-form-item">
                        <input type="text" name="alipay_url" required="" lay-verify="required" placeholder="支付宝收款码链接" autocomplete="off" class="layui-input layui-disabled bg" disabled="" id="alipay_url">
                    </div>
                    <div class="layui-form-item">
                        <input type="text" name="wechat_url" required="" lay-verify="required" placeholder="微信收款码链接" autocomplete="off" class="layui-input layui-disabled bg" disabled="" id="wechat_url">
                    </div>
                    <div class="layui-form-item">
                        <input type="text" name="qq_url" required="" lay-verify="required" placeholder="QQ收款码链接" autocomplete="off" class="layui-input layui-disabled bg" disabled="" id="qq_url">
                    </div>
                    <div class="layui-form-item">
                        <input type="text" name="nickname" required="" lay-verify="required" placeholder="请输入收款人昵称" class="layui-input" id="nickname">
                    </div>
                </div>
            </div>

            <hr>
            <ul class="am-avg-sm-1 am-avg-md-4 am-avg-lg-6 am-thumbnails">
                <style type="text/css">
                    .text-muted {text-align: center;}
                    .text-muted img{max-height:300px;height:25%;width: 100%}
                </style>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/1.jpg" id="tpl_1"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="1"> 纯黄模板</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/2.jpg" id="tpl_2"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="2"> 纯蓝款式</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/3.jpg" id="tpl_3"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="3"> 蓝底白版</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/4.jpg" id="tpl_4"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="4"> 蓝白款式</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/5.jpg" id="tpl_5"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="5"> 蓝白狗款式</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/6.jpg" id="tpl_6"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="6"> 绿色竖版</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/7.jpg" id="tpl_7"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="7"> 招财猫版</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/8.jpg" id="tpl_8"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="8"> 白绿饭团</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/9.jpg" id="tpl_9"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="9"> 白灰打印</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/10.jpg" id="tpl_10"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="10"> 灰白款式</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/11.jpg" id="tpl_11"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="11"> 红包款式</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/12.jpg" id="tpl_12"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="12"> 摔钱款式</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/13.jpg" id="tpl_13"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="13"> 绿色卡片横版</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/14.jpg" id="tpl_14"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="14"> 蓝色卡片板式</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/15.jpg" id="tpl_15"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="15"> 快捷支付</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/16.jpg" id="tpl_16"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="16"> 九月开学</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/17.jpg" id="tpl_17"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="17"> 十月国庆</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/18.jpg" id="tpl_18"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="18"> 指纹红包</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/19.jpg" id="tpl_19"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="19"> 圣诞快乐</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/20.jpg" id="tpl_20"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="20"> 简约风格</div>
                    </label>
                    </div>
                </li>
                <li>
                    <div class="am-thumbnail">
                    <label class="text-muted">
                        <img src="img/21.jpg" id="tpl_21"/><div class="am-thumbnail-caption"><input type="radio" name="tpl_id" value="21"> 小程序风格</div>
                    </label>
                    </div>
                </li>
            </ul>
            <div class="layui-row" style="text-align: center">
                <div class="layui-col-md12">
                    <input type="button" id="shorten" value="一键生成" class="layui-btn layui-btn-fluid layui-btn-radius layui-btn-normal" data-am-loading="{spinner: 'circle-o-notch',loadingText: '努力生成中...'} resetText: '请查收！'}" />
                </div>
            </div>
        </form>
        <img id="qrcode" class="am-center am-img-thumbnail am-img-responsive" style="width: 206px;display: none;">
        <img id="temp" class="am-hide">
    </div>
</div>
<div class="layui-container" style="text-align: center;">  
    <div class="layui-row" style="padding-top:50px;">
        <fieldset class="layui-elem-field">
            <legend>常见问题</legend>
            <div class="layui-field-box" style="text-align:left;line-height: 30px;">
            <b>1.合并后的收款码有扫码次数和时间限制吗？</b>
            <p>无限制扫码次数；永久可用。</p>
            <b>2.合并后的二维码安全吗？</b>
            <p>安全。技术上，我们只是对三种类型的收款码进行合并，让用户收款使用更方便</p>
            <b>3.别人扫码付款后，钱打到哪里去了？</b>
            <p>打到您的个人账户。具体来说：微信扫码付款时，钱打到您的微信钱包里；支付宝扫码付款时，钱打到您的支付宝账户里；QQ扫码付款时，钱打到您的QQ钱包里</p>
            <b>4.为什么微信、QQ扫码后还需要长按识别？</b>
            <p>微信、QQ接口未开放权限，无法直接调起微信、QQ转账页面，所以需要长按识二维码别进行转账。（给您带来不便还请谅解）目前支付宝接口已开放权限。可以直接扫码付款。</p>
            <b>5.使用此功能时，支付宝、微信、QQ会向我收取费用吗？</b>
            <p>不会。此功能是对二维码进行合并，不涉及微信、支付宝、QQ的收费问题。<p>
            <b>6.在网站上传收款码会泄露用户隐私资料吗？</b>
            <p>不会。收款码是个人的收款二维码，是客户向对方转账的一种方式，和商家平时向客户展示的收款码是一样的。</p>
            <b>7.合并后的二维码能通过微信或者支付宝或者QQ扫码转账码？</b>
            <p>可以。通过合并后的二维码可以自动识别用户扫码方式，微信扫码则使用微信支付，支付宝扫码则使用支付宝支付，QQ扫码则使用QQ支付</p>
            <b>8.合并二维码对于商家有什么好处？</b>
            <p>①对于商家来说可免中间手续费，收款直接转入到商家个体账户，不需经过第三方公司提现。</p>
            <p>②一码在手，随扫随有：只保留一个扫码牌就可以了。</p>
            <p>③此功能免费使用</p>
            </div>
        </fieldset>
        <fieldset class="layui-elem-field">
                <legend>产品优势</legend>
                <div class="layui-field-box" style="line-height: 35px;">
                <div class="layui-row">
                <div class="layui-col-md3" style="padding-right: 10px;"><img src="img/icon/1.png"><h3>一码收款</h3>通过合并后的二维码可以自动识别用户扫码方式，微信扫码则使用微信支付，支付宝扫码则使用支付宝支付，商家无需打印2个二维码，节省成本与空间。</div>
                <div class="layui-col-md3" style="padding-right: 10px;"><img src="img/icon/2.png"><h3>收益最大化</h3>全新扫码转账技术，钱直接转到商家个体 账户，收款啦不参与中间转账过程，完 全免费提供技术支持，保证商家利益。</div>
                <div class="layui-col-md3" style="padding-right: 10px;"><img src="img/icon/3.png"><h3>免提现费</h3>用户通过扫描合并后的二维码转账，直接 转到商户个体账户里，省去千分之6的手 续费。</div>
                <div class="layui-col-md3"><img src="img/icon/4.png"><h3>轻松快捷</h3>一码收款，对于用户，无需关注扫码支付 方式，直接扫码付款即可。不用担心不能 微信支付或者支付宝支付。</div>
                </div>
                </div>
        </fieldset>
    </div>
</div>
<div class="footer">
    <span style="display: none;"></span>
    <p>Copyright © 2019 <a href="http://www.ilkhome.cn">电光石火</a> | Powered by <a target="_blank" href="/">嘟嘟收款码三合一平台</a></p>
    <p>累计生成<?php echo $shengcheng['count'] ?>次，累计扫描<?php echo $saomiao['count'] ?>次</p>
</div>

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="https://lib.baomitu.com/jquery/2.1.4/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="https://lib.baomitu.com/amazeui/2.5.2/js/amazeui.min.js"></script>
<script src="https://lib.baomitu.com/validator/4.0.5/validator.min.js"></script>
<script src="https://lib.baomitu.com/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="https://lib.baomitu.com/layer/3.1.1/layer.js"></script>
<script src="static/layui/layui.js"></script>
<script type="text/javascript">
    tpl_data=new Object();
    tpl_data[1]={tpl_w: 800,tel_h:1200,tpl_src:'img/1.jpg',qr_x:120,qr_y:120,qrsize:560};
    tpl_data[2]={tpl_w:1889,tel_h:2657,tpl_src:'img/2.jpg',qr_x:530,qr_y:440,qrsize:834};
    tpl_data[3]={tpl_w:1080,tel_h:1491,tpl_src:'img/3.jpg',qr_x:370,qr_y:480,qrsize:340};
    tpl_data[4]={tpl_w:1080,tel_h:1920,tpl_src:'img/4.jpg',qr_x:175,qr_y:595,qrsize:720};
    tpl_data[5]={tpl_w:1075,tel_h:1314,tpl_src:'img/5.jpg',qr_x:327,qr_y:344,qrsize:429};
    tpl_data[6]={tpl_w:340,tel_h:600,tpl_src:'img/6.jpg',qr_x:100,qr_y:247,qrsize:140};
    tpl_data[7]={tpl_w:971,tel_h:1525,tpl_src:'img/7.jpg',qr_x:362,qr_y:674,qrsize:250};
    tpl_data[8]={tpl_w:1080,tel_h:1920,tpl_src:'img/8.jpg',qr_x:240,qr_y:900,qrsize:600};
    tpl_data[9]={tpl_w:1080,tel_h:1720,tpl_src:'img/9.jpg',qr_x:218,qr_y:448,qrsize:640};
    tpl_data[10]={tpl_w:1080,tel_h:1649,tpl_src:'img/10.jpg',qr_x:340,qr_y:610,qrsize:400};
    tpl_data[11]={tpl_w:1080,tel_h:1814,tpl_src:'img/11.jpg',qr_x:370,qr_y:575,qrsize:340};
    tpl_data[12]={tpl_w: 800,tel_h:500,tpl_src:'img/12.jpg',qr_x: 65,qr_y:130,qrsize:255};
    tpl_data[13]={tpl_w:1700,tel_h:1220,tpl_src:'img/13.jpg',qr_x:1215,qr_y:340,qrsize:220};
    tpl_data[14]={tpl_w:2560,tel_h:1440,tpl_src:'img/14.jpg',qr_x:1720,qr_y:405,qrsize:340};
    tpl_data[15]={tpl_w:3547,tel_h:4728,tpl_src:'img/15.jpg',qr_x:1210,qr_y:1656,qrsize:1126};
    tpl_data[16]={tpl_w:1080,tel_h:1920,tpl_src:'img/16.jpg',qr_x:340,qr_y:1215,qrsize:400};
    tpl_data[17]={tpl_w:567,tel_h:852,tpl_src:'img/17.jpg',qr_x:163,qr_y:348,qrsize:246};
    tpl_data[18]={tpl_w:1080,tel_h:1920,tpl_src:'img/18.jpg',qr_x:240,qr_y:950,qrsize:600};
    tpl_data[19]={tpl_w:1080,tel_h:1451,tpl_src:'img/19.jpg',qr_x:407,qr_y:823,qrsize:300};
    tpl_data[20]={tpl_w:1080,tel_h:1920,tpl_src:'img/20.jpg',qr_x:210,qr_y:625,qrsize:660};
    tpl_data[21]={tpl_w:916,tel_h:1491,tpl_src:'img/21.jpg',qr_x:300,qr_y:390,qrsize:310};
</script>
<script src="static/js/llqrcode.js"></script>
<script src="static/js/index.js?ver=15"></script>
<script>
if(false) {
    setTimeout(function(){ support(); }, 3000);
    function support(argument) {
        layer.open({
        type: 1 
        ,area: ['360px', '668px']
        ,title: '永久免费，请捐助我。'
        ,shade: 0.6 
        ,maxmin: true 
        ,anim: 2
        ,content: '<div style="text-align:center;">打开支付宝搜索“1136079” 领取现金红包<br/>扫码下方二维码进行现金打赏<br/><iframe src="http://pay.ilkhome.cn" width = "98%" height = "520px"/><br />本站永久免费生成<br />请不要让本站欠费跑路！<br /></div>'
        });
    }
}
</script>
</body>
</html>