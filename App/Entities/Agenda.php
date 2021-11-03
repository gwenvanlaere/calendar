<?php
//Entities/Agenda.php
declare(strict_types=1);

namespace App\Entities;

class Agenda
{    
    private Calendar $calendar;
    private array $agenda;
    private string $language;
    
    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
        $this->language = $calendar->getLanguage();
        $this->agenda = $calendar->show();            
    }
    public function addNote(int $day, int $month, string $note)
    {                
        $monthName = Calendar::$months[$month][$this->language];
        if (!is_array($this->agenda[$monthName][$day])) {            
            $this->agenda[$monthName][$day] = [];                  
        }
        $this->agenda[$monthName][$day][time()] = $note;
    }    

    /* getters */
    public function getContent() : array
    {
       return $this->agenda;
    }
    public function getYear() : int
    {
       return $this->calendar->getYear();
    }

    /* setters */
    public function setContent(array $content)
    {
       $this->agenda = $content;
    }
}