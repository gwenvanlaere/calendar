<?php
//Business/AgendaService.php
declare(strict_types=1);

namespace App\Business;

use App\Entities\Calendar;
use App\Entities\Agenda;
use App\Exceptions\LanguageNotSupportedException;

class AgendaService
{
    public function makeAgenda(Calendar $calendar, string $language = null) : Agenda
    {  
        if ($language) {
            if (!in_array($language, Calendar::$languages)) {
                throw new LanguageNotSupportedException();            
            }
        }      
        $agenda = new Agenda($calendar, $language);
        $content = $agenda->getContent('');
        $year = $calendar->getYear();
        
        $storSrv = new StorageService();
        
        //o> current year       
        $file = $storSrv->findFile(strval($year));        
        if (!$file) {
            $file = $storSrv->makeFile(strval($year), $content);
        }
        $agenda->setContent('', $file);
        
        //o> check for bounding years
        $nextYear = $storSrv->findFile(strval($year + 1));
        $lastYear = $storSrv->findFile(strval($year - 1)); 
        $nextYear &&  $agenda->setContent('next', $nextYear);         
        $lastYear &&  $agenda->setContent('last', $lastYear);         
          
        return $agenda;
    }
    public function addNote(Agenda $agenda, int $year, int $day, int $month, string $note) : Agenda
    {    
        $agendaYear = $agenda->getYear();
        $storSrv = new StorageService();
        $label = '';
        if ($agendaYear > $year) {
            $label = 'last';
        }     
        if ($agendaYear < $year) {
            $label = 'next';
        }
        $agenda->addNote($label, $day, $month, $note);
        $content = $agenda->getContent($label);        
        
        $storSrv = new StorageService();
        $file = $storSrv->makeFile(strval($year), $content);        
        $agenda->setContent($label, $file);        
        //$agenda = $agenda->getContent('');
        
        return $agenda;
    }
    public function removeNote(Agenda $agenda, int $year, int $day, int $month, string $timestamp) : Agenda
    {        
        $agendaYear = $agenda->getYear();
        $storSrv = new StorageService();
        $label = '';
        if ($agendaYear > $year) {
            $label = 'last';
        }     
        if ($agendaYear < $year) {
            $label = 'next';
        }
        $agenda->removeNote($label, $day, $month, $timestamp);
        $content = $agenda->getContent($label);
        $file = $storSrv->makeFile(strval($year), $content);
        $agenda->setContent($label, $file);           
        
        return $agenda;
    }
}