<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>小卖铺免费注册</title>
    <link rel="stylesheet" href="/weixin/css/login.css" />	
    <style>
	input[placeholder], [placeholder], *[placeholder] {color:#ccc !important;font-size:14px;}
        input::-webkit-input-placeholder{color:#ccc;font-size:14px;}
        input::-moz-placeholder{color:#ccc;font-size:14px;}
        input:-moz-placeholder{color:#ccc;font-size:14px;}
        input:-ms-input-placeholder{color:#ccc;font-size:14px;}
        .btn-login:active{background:#f18238;}
    </style>
</head>
<body>
    <section class="container">
        <div class="login-logo"><img src="/weixin/images/logo.png"></div>
        <div class="login-box">					
            <form action="javascript:;">
                <div class="login-form">	
                    <input type="tel"  placeholder="请输入手机" style="font-size: 18px;background-color: transparent;" id="fr-input-mobile">
                </div>
                <div class="login-form">		
                  <input type="password" placeholder="请设置登录密码" style="font-size: 18px;background-color: transparent;" id="fr-input-pwd">				    
                </div>
                <div class="login-form">		
                    <input type="text" maxlength="6" placeholder="请填写验证码" style="font-size: 18px;background-color: transparent;width: 50%;" id="fr-input-code">	
                    <div style="width:90px;background:red;float:right;text-align: center;line-height:30px;border-radius:15px;color:#fff;background: #FFA366;padding-left: 5px;padding-right:5px;margin-top:-5px;">发送短信(20s)</div>
                </div>
                <input type="submit" class=" btn-login" value="立即注册" style="font-size: 14px;font-weight: blod;" id="fr-btn-login">				 			  
            </form>
        </div>
        <div class="login-foot">
            <p>
               <span><a href="#" style="color:#afa3a3;">忘记密码？</a></span>  
               <span class="fr"><a href="{{route('w_auth_login')}}">立即登录</a></span>
            </p>				
        </div>
    </section>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="/weixin/layer_mobile/layer.js"></script>
<script>
    var obj = {
        registerLoading:false,
        numberFormater:function(val){
            //去除手机号中的空格
            return val.replace(/[^0-9]/g,"");
        },
        checkMobile:function(val){
            //验证手机号格式
            var myreg = /^1(3|4|5|7|8)\d{9}$/; 
            return myreg.test(val);
        },
        checkPassWord:function(val){
            //密码格式验证
            var str = val;
            if (str == null || str.length < 8) {
                return false;
            }

            var reg = new RegExp(/^(?![^a-zA-Z]+$)(?!\D+$)/);
            return reg.test(val);
        },
        register:function(){
            var mobile = $('#fr-input-mobile').val();
            var pwd    = $('#fr-input-pwd').val();
            var code   = $('#fr-input-code').val();
            if(mobile == ''){
                layer.open({content: '手机号不能为空',skin: 'msg',time: 2});return false;
            }else if(!this.checkMobile(mobile)){
                layer.open({content: '手机号格式错误',skin: 'msg',time: 2});return false;
            }else if(pwd == ''){
                layer.open({content: '请填写登录密码',skin: 'msg',time: 2});return false;
            }else if(!this.checkPassWord(pwd)){
                layer.open({content: '密码格式不正确',skin: 'msg',time: 2});return false;
            }

            if(this.registerLoading == false){
                var registerLoadingIndex = layer.open({type: 2,content: '注册中...'});
                $.ajax({
                    url:"{{route('w_auth_postregister')}}",
                    type:'post',
                    data:{mobile:mobile,password:pwd,code:code},
                    dataType:'json',
                    beforeSend:function(){
                        obj.registerLoading = true;
                        $('#fr-btn-login').val('注册中...');
                    },
                    complete:function(xhr, ts){
                        layer.close(registerLoadingIndex);
                        if(xhr.responseJSON.code == 200){
                            $('#fr-btn-login').val('注册成功');
                        }else{
                            obj.registerLoading = false;
                            $('#fr-btn-login').val('立即注册');
                        }
                    },
                    success:function(res){
                        if(res.code == 200){
                            layer.open({type: 2,content: '注册成功,页面跳转中...'});
                            setTimeout(function(){
                                window.location.href = "{{route('w_auth_register')}}";
                            },1000);
                        }else{
                            layer.open({content: res.message,skin: 'msg',time: 3});
                        }
                    },
                    error:function(){
                        layer.open({content: '网络繁忙，请稍后再试...',skin: 'msg',time: 2});
                    }
                });
            }else{
                layer.open({content: '注册中...',skin: 'msg',time: 2});
            }
        }
    };
    
    $('#fr-input-mobile').on('input',function(){
        $(this).val(obj.numberFormater($(this).val()))
    });
    
    $('#fr-btn-login').on('click',function(){
        obj.register();
    });
</script>
    </body>
</html>
