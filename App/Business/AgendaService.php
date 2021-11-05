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
        $content = $agenda->getContent();
        $year = $calendar->getYear();
        
        $storSrv = new StorageService();
        
        //o> current year       
        $file = $storSrv->findFile(strval($year));        
        if (!$file) {
            $file = $storSrv->makeFile(strval($year), $content);
        }
        $agenda->setContent($file);
        
        //o> check for bounding years
        $nextYear = $storSrv->findFile(strval($year + 1));
        $lastYear = $storSrv->findFile(strval($year - 1)); 
        $nextYear &&  $agenda->setNextYear($nextYear);         
        $lastYear &&  $agenda->setLastYear($lastYear);         
          
        return $agenda;
    }
    public function addNote(Agenda $agenda, int $day, int $month, string $note) : Agenda
    {        
        $year = strval($agenda->getYear());
        $agenda->addNote($day, $month, $note);
        $content = $agenda->getContent();
        
        $storSrv = new StorageService();
        $file = $storSrv->makeFile($year, $content);        
        $agenda->setContent($file);
        
        return $agenda;
    }
    public function removeNote(Agenda $agenda, int $day, int $month, string $timestamp) : Agenda
    {        
        $year = strval($agenda->getYear());
        $agenda->removeNote($day, $month, $timestamp);
        $content = $agenda->getContent();        
        
        $storSrv = new StorageService();
        $file = $storSrv->makeFile($year, $content);        
        $agenda->setContent($file);
        
        return $agenda;
    }
}