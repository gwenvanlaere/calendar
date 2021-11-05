<?php
// sessiondata.php

declare(strict_types=1);
spl_autoload_register();
set_include_path(get_include_path().PATH_SEPARATOR.realpath('..'));

use App\Business\AgendaService;
use App\Business\CalendarService;
use App\Exceptions\ExceptionsHandler;

$errors = [];
$agenda;
$calSrv = new CalendarService();
$agdSrv = new AgendaService();


if (isset($_SESSION['agenda']) && !isset($_POST['Date_Year'])) {
    $agenda = unserialize($_SESSION['agenda'], ['Agenda']); 
} else {
    $year = isset($_POST['Date_Year']) ? $_POST['Date_Year'] : date('Y');    
    try {    
        $calendar = $calSrv->makeCalendar(intval($year));    
        $agenda = $agdSrv->makeAgenda($calendar, 'nl');
        $_SESSION['agenda'] = serialize($agenda); 
    } catch(Exception $ex) {
        $exHandler = new ExceptionsHandler($ex);              
        $errors = $exHandler::$messages[$exHandler->getName()];
    }
}

//$agdSrv->addNote($agenda, 3, 11, 'trap het af');
//$agenda->addNote(3, 11, 'trap het af');

echo '<pre>';
print_r($agenda->showAgenda());
echo '</pre>';

//TODO selected year = <option selected></option>