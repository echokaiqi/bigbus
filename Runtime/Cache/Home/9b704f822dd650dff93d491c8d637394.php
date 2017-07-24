<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<title>BIG BUS</title>
<link href="/bus/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/bus/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/bus/Public/static/bootstrap/css/docs.css" rel="stylesheet">
<link href="/bus/Public/static/bootstrap/css/onethink.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/bus/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/bus/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/bus/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/bus/Public/static/bootstrap/js/bootstrap.min.js"></script>
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo U('index/index');?>">big bus</a>
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
                <ul class="nav">
                        <li>
                            <a href="javascript:void(0)" target="<?php if(($nav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>">城市公交大巴免费坐</a>
                        </li>
                </ul>
                <div class="switch" id="switch">

                    <ul class="nav" style="margin-right:0;float:right;">
                        <?php if(empty($data)): ?><li><a href="<?php echo U('User/login');?>">登录</a></li>
                        <li><a href="<?php echo U('User/register');?>" style="padding-left:0;padding-right:0">注册</a></li>

                        <?php else: ?>
                        <li><a><?php echo ($data["username"]); ?></a></li>
                        <li><a href="<?php echo U('User/logout');?>" >退出</a></li><?php endif; ?>
                    </ul>
                    <div class="switch_bottom" id="switch_bottom" style="position: absolute; width: 64px; left: 0px;"></div>
                </div>
            </div>

        </div>

    </div>
</div>

	<!-- /头部 -->
	
	<!-- 主体 -->
	
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h2>用户注册</h2>
    <p><span><span class="pull-left"><span>已经有账号? <a href="<?php echo U('User/login');?>">点此登录</a> </span> </span></p>
  </div>
</header>

<div id="main-container">
    <div class="row">
         
        

<section>
	<div class="span12">
        <form class="login-form" action="/bus/index.php?s=/User/register.html" method="post">
          <div class="control-group">
            <label class="control-label" for="inputEmail">用户名</label>
            <div class="controls">
              <input type="text" id="inputEmail" onKeyUp="value=value.replace(/[\W]/g,'')" class="span3" placeholder="请输入用户名"  ajaxurl="/member/checkUserNameUnique.html" errormsg="请填写6-16位用户名" nullmsg="请填写用户名" datatype="*6-16" value="" name="username">
            </div>

          </div>
          <div class="control-group">
            <label class="control-label" for="inputPassword">密码</label>
            <div class="controls">
              <input type="password" id="inputPassword"  class="span3" placeholder="请输入密码"  errormsg="密码为6-20位" nullmsg="请填写密码" datatype="*6-20" name="password">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputPassword">确认密码</label>
            <div class="controls">
              <input type="password" id="inputPassword" class="span3" placeholder="请再次输入密码" recheck="password" errormsg="您两次输入的密码不一致" nullmsg="请填确认密码" datatype="*" name="repassword">
            </div>
            <div class="control-group">
            <label class="control-label" for="inputsex">性别</label>
            <div class="controls">
              <input type="radio" id="inputsex" name="sex" value="0" checked="checked" >
              <span>男</span>
              <input type="radio" id="inputsex" name="sex" value="1"  >
              <span>女</span>
            </div>
          </div>
              <div class="control-group">
                  <label class="control-label" for="inputmobile">手机</label>
                  <div class="controls">
                      <input type="text" id="inputmobile" class="span3" placeholder="请输入手机号"  ajaxurl="/member/checkUserNameUnique.html" errormsg="请填写11位手机号" nullmsg="请填写手机号" datatype="*11-11" value="" name="mobile">
                  </div>
              </div>


          <div class="control-group">
            <label class="control-label" for="inputPassword">验证码</label>
            <div class="controls">
              <input type="text" id="inputPassword" class="span3" placeholder="请输入验证码"  errormsg="请填写5位验证码" nullmsg="请填写验证码" datatype="*5-5" name="verify">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <img class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('verify');?>" style="cursor:pointer;">
            </div>
            <div class="controls Validform_checktip text-warning"></div>
          </div>
          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn">注 册</button>
            </div>
          </div>
        </form>
	</div>
</section>


    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
    <footer class="footer">
      <div class="container">
          <p> 本站为 <strong style="color:#0099CC;">BIG BUS</strong> 管理平台</p>
      </div>
    </footer>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "/bus", //当前网站地址
		"APP"    : "/bus/index.php?s=", //当前项目地址
		"PUBLIC" : "/bus/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

	<script type="text/javascript">
    	$(document)
	    	.ajaxStart(function(){
	    		$("button:submit").addClass("log-in").attr("disabled", true);
	    	})
	    	.ajaxStop(function(){
	    		$("button:submit").removeClass("log-in").attr("disabled", false);
	    	});


    	$("form").submit(function(){
    		var self = $(this);
    		$.post(self.attr("action"), self.serialize(), success, "json");
    		return false;

    		function success(data){
    			if(data.status){
    				window.location.href = data.url;
    			} else {
    				self.find(".Validform_checktip").text(data.info);
    				//刷新验证码
    				$(".reloadverify").click();
    			}
    		}
    	});

		$(function(){
			var verifyimg = $(".verifyimg").attr("src");
            $(".reloadverify").click(function(){
                if( verifyimg.indexOf('?')>0){
                    $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
            });
		});
	</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>