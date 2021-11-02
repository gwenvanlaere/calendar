<?php
// sessiondata.php

declare(strict_types=1);
namespace Views;
spl_autoload_register();
use App\Business\CalendarService;

$tst = new CalendarService();
$res = $tst->makeCalendar(2020);