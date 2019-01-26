<?php
	session_start();
	
	// Check authority
	if(empty($_SESSION['manager_name'])){
		echo 'Error: You must login first!';
		header('Refresh:2; url = index.html');
		exit();
	}
	$name = $_SESSION['manager_name'];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
			管理员主页
        </title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="library/static/css/x-admin.css" media="all">
    </head>
    <body>
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header header header-demo">
                <div class="layui-main">
                    <a class="logo" href="library//index.html">
                   		<img src="static/images/logo.png"></img>
                    </a>
                    <ul class="layui-nav" lay-filter="">
                    	<li class="layui-nav-item"><img src="static/images/0.jpg" class="layui-circle" style="border: 2px solid #A9B7B7;" width="35px" alt=""></li>
                		<li class="layui-nav-item">
							<a href="javascript:;">
								<?php echo "$name"?>
								<span class="layui-nav-more"></span>
							</a>
                        	<dl class="layui-nav-child layui-anim layui-anim-upbit"> <!-- 二级菜单 -->
                        		<dd><a href="log_out.php">退出登陆</a></dd>
                        </dl>
                      	</li>
                    	<li class="layui-nav-item x-index"><a href="index.html">前台首页</a></li>
                    </ul>
                </div>
			</div>

		<div class="layui-side layui-bg-black x-side">
                <div class="layui-side-scroll">
                    <ul class="layui-nav layui-nav-tree site-demo-nav" lay-filter="side">
                    <!--图书管理-->
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;" _href="">
                               <i class="layui-icon" style="top: 3px;">&#xe62d;</i><cite>图书管理</cite>
                            </a>
                      		<dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/manage_book.html">
                                           <cite>图书查找与编辑</cite>
                                        </a>
                              </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/insert_book.html">
                                            <cite>图书录入</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                        <!--管理员管理-->
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;" _href="">
                                <i class="layui-icon" style="top: 3px;">&#xe613;</i><cite>管理员管理</cite>
							</a>
							<dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/manager_information.html">
                                           <cite>管理员信息</cite>
                                        </a>
                              </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/manager_create.html">
                                            <cite>注册新管理员</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                        <!--借书证管理-->
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;" _href="">
                                <i class="layui-icon" style="top: 3px;">&#xe612;</i><cite>借书证管理</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/card_information.html">
                                           <cite>借书证查询与删除</cite>
                                        </a>
                              </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/card_create.html">
                                            <cite>新借书证注册</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                        <!--借书与归还-->
                        <li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:;">
                                <i class="layui-icon" style="top: 3px;">&#xe629;</i><cite>借书与归还</cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/borrow_search.html">
                                            <i class="layui-icon"></i><cite>借书</cite>
                                        </a>
                                    </dd>
                                </dd>
                                <dd class="">
                                    <dd class="">
                                        <a href="javascript:;" _href="library/static/return_search.html">
                                            <i class="layui-icon"></i><cite>还书</cite>
                                        </a>
                                    </dd>
                                </dd>
                            </dl>
                        </li>
                    </ul>
                </div>
            </div>
			<div class="layui-tab layui-tab-card site-demo-title x-main" lay-filter="x-tab" lay-allowclose="true">
                <div class="x-slide_left"></div>
                <ul class="layui-tab-title">
                    <li class="layui-this">
                        图书查找与编辑
                        <i class="layui-icon layui-unselect layui-tab-close">ဆ</i>
                    </li>
                </ul>
                <div class="layui-tab-content site-demo site-demo-body">
                    <div class="layui-tab-item layui-show">
                        <iframe frameborder="0" src="library/static/manage_book.html" class="x-iframe"></iframe>
                    </div>
                </div>
            </div>
            <div class="site-mobile-shade">
			</div>

		</div>
	</body>

	<script src="library/static/lib/layui/layui.js" charset="utf-8"></script>
    <script src="library/static/js/x-admin.js"></script>

</html>

