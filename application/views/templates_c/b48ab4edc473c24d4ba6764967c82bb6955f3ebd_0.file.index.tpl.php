<?php
/* Smarty version 3.1.32, created on 2018-05-14 17:37:07
  from '/Applications/MAMP/htdocs/study/yaf/application/views/login/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af958c30612a0_18846999',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b48ab4edc473c24d4ba6764967c82bb6955f3ebd' => 
    array (
      0 => '/Applications/MAMP/htdocs/study/yaf/application/views/login/index.tpl',
      1 => 1526290625,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5af958c30612a0_18846999 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
hui/lib/html5shiv.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
hui/lib/respond.min.js"><?php echo '</script'; ?>
>
    <![endif]-->
    <link href="<?php echo @constant('__STATIC__');?>
hui/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo @constant('__STATIC__');?>
hui/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo @constant('__STATIC__');?>
hui/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo @constant('__STATIC__');?>
hui/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
    <!--[if IE 6]>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
hui/lib/DD_belatedPNG_0.0.8a-min.js" ><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>DD_belatedPNG.fix('*');<?php echo '</script'; ?>
>
    <![endif]-->
    <title>后台登录 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<div class="header"></div>

<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <form class="form form-horizontal" action="http://yaff.colorful.com/admin/login/index" method="post">
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input id="username" name="username" type="text" placeholder="账户" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
                </div>
            </div>
                                                                                            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <label for="online">
                        <input type="checkbox" name="online" id="online" value="">
                        使我保持登录状态</label>
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input id="login_btn" type="button" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                    <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                </div>
            </div>
        </form>
    </div>
</div>


<div class="footer">Copyright 你的公司名称 by H-ui.admin v3.1</div>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
hui/lib/jquery/1.9.1/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
hui/static/h-ui/js/H-ui.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
hui/lib/layer/2.4/layer.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
common/admin/common.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('__STATIC__');?>
common/admin/login.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
