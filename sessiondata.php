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
if(isset($_GET['action'])) {
    $day = $_GET['d'];
    $month = intval($_GET['m']);
    $year = $agenda->getYear();       
    /* next or previous month */
    /* switch year if month is 1 or 12 */
    if ($day[0] === '+') {
        $day = explode('+', $day)[1];
        $year = $month === 12 ? $year + 1 : $year; 
        $month = $month === 12 ? 1 : $month + 1;
    } elseif ($day[0] === '-') {
        $day = explode('-', $day)[1];
        $year = $month === 1 ? $year - 1 : $year;
        $month = $month === 1 ? 12 : $month - 1;            
    }
    if (isset($_POST['note'])) {        
        $note = htmlspecialchars($_POST['note']);
        try {
            $agenda = $agdSrv->addNote($agenda, $year, intval($day), $month, $note);        
        } catch(Exception $ex) {
            $exHandler = new ExceptionsHandler($ex);              
            $errors = $exHandler::$messages[$exHandler->getName()];
        }
    } else {
        try {
            $agenda = $agdSrv->removeNote($agenda, $year, intval($day), $month, $_GET['stamp']);        
        } catch(Exception $ex) {
            $exHandler = new ExceptionsHandler($ex);              
            $errors = $exHandler::$messages[$exHandler->getName()];
        }
    }
}

$firstDay = $agenda->getFirstDayOfWeek();
$_SESSION['agenda'] = serialize($agenda);

!empty($errors)  && print_r('<pre style="color:red;font-weight:bold">' . $errors . '</pre>');

//TODO selected year = <option selected></option>