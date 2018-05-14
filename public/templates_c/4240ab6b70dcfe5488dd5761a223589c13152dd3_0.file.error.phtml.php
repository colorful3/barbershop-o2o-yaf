<?php
/* Smarty version 3.1.32, created on 2018-05-14 19:43:49
  from '/Applications/MAMP/htdocs/study/yaf/application/views/error/error.phtml' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5af976758dac01_34784895',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4240ab6b70dcfe5488dd5761a223589c13152dd3' => 
    array (
      0 => '/Applications/MAMP/htdocs/study/yaf/application/views/error/error.phtml',
      1 => 1525906554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5af976758dac01_34784895 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?php
';?>echo "Error Msg:"  . $exception->getMessage();
<?php echo '?>';
}
}
