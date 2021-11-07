<?php
/* Smarty version 3.1.40, created on 2021-11-07 17:09:08
  from 'C:\xampp\htdocs\gwen\calendar\Views\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_6187fa24452fe9_14089245',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ba247020e2d52ca8b5e397bf77889dcd0dcf7e5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\gwen\\calendar\\Views\\templates\\index.tpl',
      1 => 1636301340,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_6187fa24452fe9_14089245 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\xampp\\htdocs\\gwen\\calendar\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.capitalize.php','function'=>'smarty_modifier_capitalize',),1=>array('file'=>'C:\\xampp\\htdocs\\gwen\\calendar\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),2=>array('file'=>'C:\\xampp\\htdocs\\gwen\\calendar\\vendor\\smarty\\smarty\\libs\\plugins\\function.html_select_date.php','function'=>'smarty_function_html_select_date',),3=>array('file'=>'C:\\xampp\\htdocs\\gwen\\calendar\\vendor\\smarty\\smarty\\libs\\plugins\\function.html_radios.php','function'=>'smarty_function_html_radios',),4=>array('file'=>'C:\\xampp\\htdocs\\gwen\\calendar\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.regex_replace.php','function'=>'smarty_modifier_regex_replace',),));
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "test.conf", "setup", 0);
?>

<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'Calendar'), 0, false);
?>

<PRE>

    <?php if ($_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'bold')) {?><b><?php }?>
                Title: <?php echo smarty_modifier_capitalize($_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'title'));?>

        <?php if ($_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'bold')) {?></b><?php }?>

    The current date and time is <?php echo smarty_modifier_date_format(time(),"%Y-%m-%d %H:%M:%S");?>
    

    Example of accessing server environment variable SERVER_NAME: <?php echo $_SERVER['SERVER_NAME'];?>


    The value of {$Name} is <b><?php echo $_smarty_tpl->tpl_vars['Name']->value;?>
</b>

variable modifier example of {$Name|upper}

<b><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['Name']->value, 'UTF-8');?>
</b>


</PRE>

This is an example of the html_select_date function:

<p>SELECTED: <?php echo $_smarty_tpl->tpl_vars['selected_year']->value;?>
</p>
<form action='<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
' method='post' id="selectYear">
    <?php echo smarty_function_html_select_date(array('start_year'=>'-5','end_year'=>'+5','field_order'=>'YMD','display_days'=>false,'display_months'=>false),$_smarty_tpl);?>

</form>

<article class="agenda">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['agenda']->value, 'month');
$_smarty_tpl->tpl_vars['month']->iteration = 0;
$_smarty_tpl->tpl_vars['month']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['month']->key => $_smarty_tpl->tpl_vars['month']->value) {
$_smarty_tpl->tpl_vars['month']->do_else = false;
$_smarty_tpl->tpl_vars['month']->iteration++;
$__foreach_month_0_saved = $_smarty_tpl->tpl_vars['month'];
?>
        <section class="month">
            <?php echo smarty_function_html_radios(array('name'=>'month','output'=>$_smarty_tpl->tpl_vars['month']->key,'values'=>$_smarty_tpl->tpl_vars['month']->iteration,'labels'=>false,'selected'=>$_smarty_tpl->tpl_vars['selected_month']->value),$_smarty_tpl);?>

            <ul class="monthList">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['month']->value, 'day');
$_smarty_tpl->tpl_vars['day']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value) {
$_smarty_tpl->tpl_vars['day']->do_else = false;
$__foreach_day_1_saved = $_smarty_tpl->tpl_vars['day'];
?>
                    <li class='day' data-month='<?php echo $_smarty_tpl->tpl_vars['month']->iteration;?>
' data-day='<?php echo $_smarty_tpl->tpl_vars['day']->key;?>
'>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['day']->value, 'notes');
$_smarty_tpl->tpl_vars['notes']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['notes']->key => $_smarty_tpl->tpl_vars['notes']->value) {
$_smarty_tpl->tpl_vars['notes']->do_else = false;
$__foreach_notes_2_saved = $_smarty_tpl->tpl_vars['notes'];
?>
                            <details>
                                <summary <?php if (!empty($_smarty_tpl->tpl_vars['notes']->value)) {?> class="modified" <?php }?>><?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['day']->key,"/[-+]/"," ");?>
</summary>
                                <ul>
                                    <li class="dayName">
                                        <h2><?php echo $_smarty_tpl->tpl_vars['notes']->key;?>
</h2>
                                    </li>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['notes']->value, 'note');
$_smarty_tpl->tpl_vars['note']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['note']->key => $_smarty_tpl->tpl_vars['note']->value) {
$_smarty_tpl->tpl_vars['note']->do_else = false;
$__foreach_note_3_saved = $_smarty_tpl->tpl_vars['note'];
?>
                                        <li>
                                            <p class="note"><?php echo $_smarty_tpl->tpl_vars['note']->value;?>
</p>
                                            <time><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['note']->key,'%e %b, %Y, %H:%M:%S');?>
</time>
                                            <a
                                                href='<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
?action=delete&d=<?php echo urlencode($_smarty_tpl->tpl_vars['day']->key);?>
&m=<?php echo $_smarty_tpl->tpl_vars['month']->iteration;?>
&stamp=<?php echo $_smarty_tpl->tpl_vars['note']->key;?>
'>delete</a>
                                        </li>
                                    <?php
$_smarty_tpl->tpl_vars['note'] = $__foreach_note_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <?php
$_smarty_tpl->tpl_vars['notes'] = $__foreach_notes_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                <form action="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
?action=add&d=<?php echo urlencode($_smarty_tpl->tpl_vars['day']->key);?>
&m=<?php echo $_smarty_tpl->tpl_vars['month']->iteration;?>
"
                                    method='post'>
                                    <input type="submit" value="Add">
                                    <input type='text' name='note'>
                                </form>
                            </ul>
                        </details>
                    </li>
                <?php
$_smarty_tpl->tpl_vars['day'] = $__foreach_day_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </ul>
        </section>
    <?php
$_smarty_tpl->tpl_vars['month'] = $__foreach_month_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</article>

<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
