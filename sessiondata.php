<?php
// sessiondata.php

declare(strict_types=1);
spl_autoload_register();
set_include_path(get_include_path().PATH_SEPARATOR.realpath('..'));

use App\Business\AgendaService;
use App\Business\CalendarService;

$calSrv = new CalendarService();
$calendar = $calSrv->makeCalendar(2020, 'en');
$agdSrv = new AgendaService();
$agenda = $agdSrv->makeAgenda($calendar)->getContent();