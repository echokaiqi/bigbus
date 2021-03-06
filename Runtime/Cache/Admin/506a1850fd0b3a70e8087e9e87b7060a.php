<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>共享班车</title>
    <link href="/bus/Public/LO.png" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/bus/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/bus/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/bus/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/bus/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/bus/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
    <script src="/bus/Public/Admin/js/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="/bus/Public/Admin/js/amcharts/serial.js" type="text/javascript"></script>
    <script src="/bus/Public/Admin/js/amcharts/pie.js" type="text/javascript"></script>
    <!-- theme files. you only need to include the theme you use.
         feel free to modify themes and create your own themes -->
    <script src="/bus/Public/Admin/js/amcharts/themes/light.js" type="text/javascript"></script>
    <script src="/bus/Public/Admin/js/amcharts/themes/dark.js" type="text/javascript"></script>
    <script src="/bus/Public/Admin/js/amcharts/themes/chalk.js" type="text/javascript"></script>
    <script src="/bus/Public/Admin/js/amcharts/themes/patterns.js" type="text/javascript"></script>
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/bus/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/bus/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/bus/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="span_title">

        </span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

            <span class="span_title">
                欢迎使用,<?php echo ($place["title"]); ?>
            </span>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i; if(is_array($rules)): $i = 0; $__LIST__ = $rules;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rule): $mod = ($i % 2 );++$i; if( $menu["id"] == $rule ): ?><li>
                                            <a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                        </li>
                                    <?php else: endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
    <div class="main-title">
        <h2>班车调度</h2>
    </div>
    <?php if(!empty($data)): ?><form action="<?php echo U();?>" method="post" class="form-Route-add">
        <div class="form-item">
            <label class="item-label"></label>
            <div class="controls">
                班车名称 : <?php echo ($data["name"]); ?>
                <br />
                班车类型 : <?php echo ($data["title"]); ?>
                <br />
                乘车人数 : <?php echo ($data["number"]); ?>
            </div>

        </div>

        <div class="form-item" id="place" style="display:none;">
            <br />
            <label class="item-label">公司调度<span class="check-tips">（请选择调度的公司）</span></label>
            <div class="controls">
                <select name="place" id="pvce">
                    <?php if(is_array($places)): $i = 0; $__LIST__ = $places;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" ><?php echo ($v["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <br />
        <?php if(empty($route)): ?><td colspan="9" class="text-center"> 该公司所在位置未添加线路! </td>
            <?php else: ?>
            <div class="form-item">
                <label class="item-label" id="route-tit">线路类型<span class="check-tips">（请核实你的线路）</span></label>
                <div class="controls">
                    <select name="rid" id="routle">
                        <?php if(is_array($route)): $i = 0; $__LIST__ = $route;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ro): $mod = ($i % 2 );++$i; if( $ro["id"] == $data.rid): ?><option value="<?php echo ($ro["id"]); ?>" selected="selected" class="rou"><?php echo ($ro["title"]); ?></option>

                                <?php else: ?>

                                <option value="<?php echo ($ro["id"]); ?>" class="rou" ><?php echo ($ro["title"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <br />
            <span id="ddd111">

            </span><?php endif; ?>

        <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
        <div class="form-item">
            <button class="btn submit-btn Rotue-subbtn" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
        <br />
        <input type="button" class="button_place" value="点击核实你的公司">
        <span id="span111">

        </span>


    </form>
        <?php else: ?>
        <td colspan="9" class="text-center"> 请选择正确的进入方式,如需要调度请到线路列表或班车列表进行指定! </td><?php endif; ?>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">欢迎使用<strong style="color:#0066cc;">共享大巴</strong>管理平台</div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/bus", //当前网站地址
            "APP"    : "/bus/admin.php?s=", //当前项目地址
            "PUBLIC" : "/bus/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/bus/Public/static/think.js"></script>
    <script type="text/javascript" src="/bus/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
    <script type="text/javascript">
        //导航高亮
        highlight_subnav('<?php echo U('Bus/upd');?>');

        $(function(){
            $(".Rotue-subbtn").click(function(){

            });
            $(".button_place").click(function(){
               $("#place").slideDown();
                $(this).val("请根据要求进行调度!");
                $(this).css('color','red');
            });
            $("#pvce").change(function(){
                var id = $(this).children('option:selected').val();
                $("#routle").children().remove();
                $.ajax({
                    type:'post',
                    url:"<?php echo U('Bus/changeRoute');?>",
                    data:{id:id},
                    dataType:'json',
                    success:function(data){
                        if(data != null){
                            $(data).each(function(){
                                if(this.id != ''){
                                   $("#routle").append("<option value='"+this.id+"'>"+this.title+"</option>");
                                }
                            })
                        }else{
                            $("#routle").remove();
                            $("#route-tit").html('该城市未开通线路,请前去添加线路后在调度!');
                            $("#route-tit").css('color','red');
                        }
                    }
                })
            })
        });

    </script>
    <!--<script type="text/javascript">
        function place(id){
            var obj = document.getElementById('pace'+id);
        }
    </script>-->

</body>
</html>