<?php
//Business/AgendaService.php
declare(strict_types=1);

namespace App\Business;

use App\Entities\Calendar;
use App\Entities\Agenda;

class AgendaService
{
    public function makeAgenda(Calendar $calendar) : Agenda
    {        
        $agenda = new Agenda($calendar);
        $content = $agenda->getContent();
        $year = strval($calendar->getYear());
        
        $storSrv = new StorageService();
        $file = $storSrv->findFile($year);        
        if (!$file) {
            $file = $storSrv->makeFile($year, $content);
        }        
        $agenda->setContent($file);
                    
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
}