<?php
/* Smarty version 3.1.40, created on 2021-11-02 13:01:17
  from 'C:\xampp\htdocs\gwen\calendar\Views\templates\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_6181288d7f2c46_92177336',
  'has_nocache_code' => true,
  'file_dependency' => 
  array (
    '82c051c108d6f064f4412311b3d0f87a313cd0a7' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gwen\\calendar\\Views\\templates\\header.tpl',
      1 => 1635854473,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6181288d7f2c46_92177336 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '12101665236181288d7be8a8_28704932';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo '<script'; ?>
 src='../Assets/js/calendar.js' defer><?php echo '</script'; ?>
>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"><?php echo '</script'; ?>
>
    <link rel="stylesheet" href="../Assets/css/caldendar.css">
    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
 - <?php echo '/*%%SmartyNocache:12101665236181288d7be8a8_28704932%%*/<?php echo $_smarty_tpl->tpl_vars[\'Name\']->value;?>
/*/%%SmartyNocache:12101665236181288d7be8a8_28704932%%*/';?>
</title>
</head>

<body>

</body><?php }
}
