<?php
/**
 * Example Application
 *
 * @package Example-application
 */
include('../vendor/smarty/smarty/libs/Smarty.class.php');
include('../sessiondata.php');

$smarty = new Smarty;
//$smarty->force_compile = true;
$smarty->debugging = true;
// $smarty->caching = true;
$smarty->cache_lifetime = 120;
$smarty->assign("Name", "Gwen Van Laere", true);

$selected_year = $agenda->getYear();
$selected_month = $selected_year == date("Y") ? date("m") : 1;

$smarty->assign('errors', $errors);
$smarty->assign('daysInWeek', 8);
$smarty->assign('firstDay', $firstDay);
$smarty->assign('agenda', $agenda->showAgenda(true));
$smarty->assign('selected_year', $selected_year);
$smarty->assign('selected_month', $selected_month);

$smarty->display('index.tpl');