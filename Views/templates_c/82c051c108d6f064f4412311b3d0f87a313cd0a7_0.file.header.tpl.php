<?php
/* Smarty version 3.1.40, created on 2021-11-03 16:15:11
  from 'C:\xampp\htdocs\gwen\calendar\Views\templates\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_6182a77f83f2a2_45445013',
  'has_nocache_code' => false,
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
function content_6182a77f83f2a2_45445013 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
 - <?php echo $_smarty_tpl->tpl_vars['Name']->value;?>
</title>
</head>

<body>

</body><?php }
}
