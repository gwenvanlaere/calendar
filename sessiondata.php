<?php
// sessiondata.php

declare(strict_types=1);
spl_autoload_register();
set_include_path(get_include_path().PATH_SEPARATOR.realpath('..')); /* a lil hacky */

use App\Business\AgendaService;
use App\Business\CalendarService;
use App\Exceptions\ExceptionsHandler;

/*********** SESSION **********/
if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}
//session_destroy();

/*********** VARIABLES **********/
$errors = [];
$agenda;

$calSrv = new CalendarService();
$agdSrv = new AgendaService();

/*********** AGENDA **********/
if (isset($_SESSION['agenda']) && !isset($_POST['Date_Year'])) {
    $agenda = unserialize($_SESSION['agenda'], ['Agenda']);
    print_r('<pre style="color:green;font-weight:bold">In session!!!!</pre>');    
} else {    
    $year = isset($_POST['Date_Year']) ? $_POST['Date_Year'] : date('Y');    
    try {         
        $calendar = $calSrv->makeCalendar(intval($year));    
        $agenda = $agdSrv->makeAgenda($calendar, 'nl');
    } catch(Exception $ex) {
        $exHandler = new ExceptionsHandler($ex);              
        $errors = $exHandler::$messages[$exHandler->getName()];
    }
}

try {
    //$agdSrv->addNote($agenda, 2, 6, 'tis 2 juni iere');
    //$agdSrv->addNote($agenda, 4, 11, 'and now for something completely different');
    //$agdSrv->removeNote($agenda, 3, 11, '1636007331');
} catch(Exception $ex) {
    $exHandler = new ExceptionsHandler($ex);              
    $errors = $exHandler::$messages[$exHandler->getName()];
}
$firstDay = $agenda->getFirstDayOfWeek();
$_SESSION['agenda'] = serialize($agenda);

//$agenda = $agenda->showAgenda(true);
echo '<pre>';
print_r($agenda->showAgenda(true));
echo '</pre>';

!empty($errors)  && print_r('<pre style="color:red;font-weight:bold">' . $errors . '</pre>');

//TODO selected year = <option selected></option>