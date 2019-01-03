function urlEncode(String) {
    return encodeURIComponent(String).replace(/'/g,"%27").replace(/"/g,"%22");  
}
function handleFiles(e){
        var id = $(e).attr("id");
        console.log(id);
        url = getObjectURL(e.files[0]);
        qrcode.decode(url);
        qrcode.callback = function(imgMsg){
            if (imgMsg=='error decoding QR Code') {alert('解析失败，请手动解码或者更换二维码！')}
            $('#'+id+'_url').val(imgMsg);
        }
}
function getObjectURL(file){
    let url = null ; 
    if (window.createObjectURL!=undefined) { // basic
        url = window.createObjectURL(file) ;
    } else if (window.URL!=undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file) ;
    } else if (window.webkitURL!=undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
}

$(document).ready(function() {
    $("#alipay,#wechat,#qq").change(function($this) {
        handleFiles(this);
    });
    /*$("#qq").change(function($this) {
        var formData = new FormData(); 
        formData.append('Filedata', $('#qq')[0].files[0]); 
        var scan = layer.msg('识别中,请稍候！', { icon: 16 ,shade: 0.01,time: 2000000});
        $.ajax({  
            url: 'https://upload.api.cli.im/upload.php?kid=cliim',  
            type: 'POST',  
            cache: false,
            data: formData,
            processData: false, 
            contentType: false, 
            success: function (a) {
                var data = $.parseJSON(a);
                console.log(data);
                if(data.status==1){
                    $.get('https://api.uomg.com/api/qr.encode',{url:data.data.path}, function(qr) {
                        $('#qq_url').val(qr.qrurl);
                        layer.close(scan);
                        console.log(qr);
                    });
                }else{
                    layer.msg(data.msg);
                }
            },  
            error: function (msg) {  
                layer.msg('解码失败，请手动解码！');
            }  
        });
        //handleFiles(this);
    });*/
    $('#shorten').click(function(){
        var alipay_url = $("#alipay_url").val(); 
        if ((null == alipay_url) || ("" == alipay_url)) { 
            layer.msg("请上传支付宝收款码！", { icon: 7 }); 
            return false;
        }
        var wechat_url = $("#wechat_url").val(); 
        if ((null == wechat_url) || ("" == wechat_url)) { 
            layer.msg("请上传微信收款码！", { icon: 7 }); 
            return false;
        }
        var qq_url = $("#qq_url").val(); 
        if ((null == qq_url) || ("" == qq_url)) { 
            layer.msg("请上传QQ收款码！", { icon: 7 }); 
            return false;
        }
        var tpl_id = $(":radio[name=tpl_id]:checked").val(); 
        if (null == tpl_id) { 
            layer.msg("请选择生成模板！", { icon: 7 }); 
            return false;
        }
        var nicknameo = $("#nickname").val(); 
        if ((null == nicknameo) || ("" == nicknameo)) { 
            nicknameo = "我";
        }
        
        var loading = layer.msg('加载中,请稍候！', { icon: 16 ,shade: 0.01,time: 2000000});
        var ali = urlEncode(alipay_url),
        wx = urlEncode(wechat_url),
        qq = urlEncode(qq_url),
        nickname = urlEncode(nicknameo);
        data = tpl_data[tpl_id];

        var qrImg = document.getElementById("temp");
        qrImg.crossOrigin = 'Anonymous';
        qrImg.src = './paycode.php?alipay='+ali+'&qqpay='+qq+'&wxpay='+wx+'&nickname='+nickname;
        $(qrImg).load(function(){
            setTimeout(resetCanvas(data,tpl_id,loading),500);
        });
    });
});
function resetCanvas(data,id,loading){
    console.log('resetCanvas');
    var BjImg = document.getElementById("tpl_"+id),
    canvas = document.createElement("canvas"),
    cxt = canvas.getContext("2d");

    BjImg.crossOrigin = 'Anonymous';
    BjImg.src = data['tpl_src'];

    $(BjImg).load(function(){
        canvas.width = data['tpl_w'];
        canvas.height = data['tel_h'];
        cxt.fillStyle = "#fff";
        cxt.fillRect(0,0,canvas.width,canvas.height);

        cxt.save();
        cxt.drawImage(BjImg,0,0);
        cxt.restore();

        createQr(canvas,data);
    });
}
function createQr(canvas,data,loading){
    console.log('createQr');
    var qrImg = document.getElementById("temp"),
    ncxt = canvas.getContext('2d');

    ncxt.drawImage(qrImg,data['qr_x'],data['qr_y'],data['qrsize'],data['qrsize']);
    mixEnd(canvas,loading);

};
function mixEnd(canvas,loading){
    console.log('mixEnd');
    var img = document.getElementById("qrcode");
    img.src = canvas.toDataURL("image/jpeg");
    img.style.display='block';
    layer.close(loading);
    layer.msg('长按保存图片，或者鼠标右键图片！');
};
