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
	
    <header class="jumbotron subhead" id="overview" style="text-align: center;">
        <div class="container">
            <h2>BIG BUS 共享大巴！</h2>
            <p class="lead"></p>
        </div>
    </header>

<div id="main-container">
    <div class="row">
        
<!-- 左侧 nav
================================================== -->


        
    <div class="span9" style="text-align: center;" >

        <a href="/bus/admin.php" style="text-decoration: none;">
            <h1 style="margin-top: 80px;margin-left: 440px;">
            进入管理中心
            </h1>
        </a>
        </section>
    </div>

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
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>