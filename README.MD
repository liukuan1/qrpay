## 嘟嘟收款码
演示站点(http://pay.dopan.net)
嘟嘟收款码，是一款支付宝、微信、QQ收款码三合一整合系统。
绝大多数的三合一仅仅只是针对个人使用，而嘟嘟收款码能对多用户提供三合一服务。
采用 PHP + MySQL + layui  完成


## 原理
收款码三合一，听上去感觉很神奇，其实原理非常简单！

所谓二维码，其实就是包含了一系列字符串的图片罢了。无论是支付宝还是微信的收款码，其本质上是一个包含了收款链接的二维码。所以我们的思路是：检测如果是支付宝浏览页面，就给出支付宝的付款链接、如果是微信，就给出微信链接……

然后这里涉及到一个知识点，`User-Agent`,大厂的webview都会携带自家的UA信息，比如说：

QQ：`MQQBrowser/6.2 TBS/043221 Safari/537.36 QQ/7.0.0.3135`

微信：`MQQBrowser/6.2 TBS 043220 Safari/537.36 MicroMessenger/6.5.8.1060 NetType/4G Language/zh_CN`

支付宝：`UCBrowser/11.5.0.939 UCBS/2.10.1.6 Mobile Safari/537.36 AliApp(AP/10.0.15.051805) AlipayClient/10.0.15.051805 Language/zh-Hans`

这样就很轻松区分是QQ还是微信还是支付宝扫码了：

`User-Agent` 含有 QQ/ 为QQ

`User-Agent` 含有 MicroMessenger 为微信

`User-Agent` 含有 AlipayClient 为支付宝

既然能够区分每个软件，那就可以通过自建一个网址，通过二维码生成扫描这个网址后，判断浏览器的UA，来分发不同的收款码

大致的流程则为：

客户端扫码 -> 服务端根据 `User-Agent` 判断客户端类型 -> 分别返回不同的处理

另外值得注意的是：

支付宝：https 协议，可直接唤醒支付宝 APP

微信：微信自己的支付协议，无法唤醒微信

QQ：https 协议，无法唤醒QQ

## 安装
0. PHP >= 5.6  + MySQL

1. 将代码部署到你的服务器中

2. 将根目录`pay.sql`导入你的数据库中

3. 修改`inc\config.php`为自己数据库信息和站点网址

必须按步骤来


## Author

© Released under the [APACHE2](./LICENSE) License.<br>
如果可以的话，请打赏作者一份,赞助我一下服务器
![zanzhu](http://pay.ilkhome.cn/pay.jpg)
> [Blog](http://www.ilkhome.cn) · GitHub [©陌晴](https://github.com/178146582)
