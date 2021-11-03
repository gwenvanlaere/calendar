<?php
//Entities/Agenda.php
declare(strict_types=1);

namespace App\Entities;

use App\Exceptions\CannotRemoveNoteException;

class Agenda
{    
    private Calendar $calendar;
    private array $agenda;
    private string $language;
    
    public function __construct(Calendar $calendar, string $language = null)
    {
        $this->calendar = $calendar;
        $this->language = $language ?? 'en';
        $this->agenda = $calendar->show();            
    }    
    public function addNote(int $day, int $month, string $note)
    { 
        if (!is_array($this->agenda[$month][$day])) {
            $weekday = $this->agenda[$month][$day];                 
            $this->agenda[$month][$day] = [$weekday => []];                  
        }
        $weekday = key($this->agenda[$month][$day]);
        $this->agenda[$month][$day][$weekday][time()] = $note;
    }
    public function removeNote(int $day, int $month, string $timestamp)
    {
        $weekday = key($this->agenda[$month][$day]);        
        if (isset($this->agenda[$month][$day][$weekday][$timestamp])) {            
            unset($this->agenda[$month][$day][$weekday][$timestamp]);
        } else {
            throw new CannotRemoveNoteException();
        }
        if (empty($this->agenda[$month][$day][$weekday])) {
            $this->agenda[$month][$day] = $weekday;
        }
    }   

    /* getters */
    public function getContent() : array
    {
       return $this->agenda;
    }
    
    public function getLanguage() : string
    {
       return $this->language;
    }
    public function getYear() : int
    {
       return $this->calendar->getYear();
    }
    public function showAgenda() : array
    {
        $lang = $this->language;
        $output = [];      
        foreach ($this->agenda as $monthNumber => $days) {            
            $monthName = Calendar::$months[intval($monthNumber)][$lang];                    
            foreach ($days as $day => $dayNumber) {
                if (is_array($dayNumber)) {
                    $weekday = Calendar::$days[intval(key($dayNumber))][$lang];
                    $output[$monthName][$day][$weekday] = $dayNumber[key($dayNumber)];                    
                } else {
                    $weekday = Calendar::$days[intval($dayNumber)][$lang];
                    $output[$monthName][$day] = $weekday;
                }
            }
        }       
        return $output;
    }

    /* setters */
    public function setContent(array $content)
    {
       $this->agenda = $content;
    }
}