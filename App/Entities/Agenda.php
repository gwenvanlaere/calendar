<?php
//Entities/Agenda.php
declare(strict_types=1);

namespace App\Entities;

use App\Exceptions\CannotRemoveNoteException;
use App\Exceptions\NoNotesFoundForThisDayException;
use App\Exceptions\NoteDoesNotExistException;

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
        if (!is_array($this->agenda[$month][$day])) {
            throw new NoNotesFoundForThisDayException();
        }
        $weekday = key($this->agenda[$month][$day]);
        if (isset($this->agenda[$month][$day][$weekday][$timestamp])) {            
            unset($this->agenda[$month][$day][$weekday][$timestamp]);
        } else {
            throw new NoteDoesNotExistException();
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
    public function getFirstDayOfWeek() : string
    {
       return Calendar::$days[1][$this->language];
    }
    public function showAgenda(bool $trailingDays = null) :  array
    { 
        $output = [];
        $agenda = $this->agenda;
        foreach ($agenda as $monthNumber => $days) {                       
            $monthName = Calendar::$months[intval($monthNumber)][$this->language];
            
            //l> trailing days before                      
            if ($trailingDays) {
                $previousMonth = $monthNumber === 1
                    ? $this->calendar->getDecemberOfLastYear() /* last days of last year */
                    : $agenda[$monthNumber - 1];
                $output[$monthName] = $this->getPrecedingDays($previousMonth, $monthNumber);
            }
            //l> -----------------------
           
            foreach ($days as $day => $dayNumber) {
                if (is_array($dayNumber)) {                    
                    $weekday = Calendar::$days[intval(key($dayNumber))][$this->language];
                    $output[$monthName][$day][$weekday] = $dayNumber[key($dayNumber)];                    
                } else {
                    $weekday = Calendar::$days[intval($dayNumber)][$this->language];
                    $output[$monthName][$day] = [$weekday => []];
                }
            }
            
            //l> trailing days after  
            if ($trailingDays) {
                $nextMonth = $monthNumber === 12
                ? $this->calendar->getJanuaryOfNextYear() /* first days of next year */
                : $agenda[$monthNumber + 1];
                $output[$monthName] += $this->getFollowingDays($nextMonth, $monthNumber);
            }
            //l> -----------------------
        }             
        return $output;
    }
    public function getPrecedingDays(array $prevMonth, int $month) : array
    {   
        $output = [];        
        $firstDay = $this->calendar->getFirstDayOfMonth($month) - 1; /* exclude this day */       
        $count = count($prevMonth) + 1; /* correction = array start = 0, day start = 1 */        
        for ($i = $firstDay; $i > 0 ; $i--) {            
            if (is_array($prevMonth[$count - $i])) {
                $dayIndex = key($prevMonth[$count - $i]);                
                $weekday = Calendar::$days[$dayIndex][$this->language]; 
                $output['-' . ($count - $i)][$weekday] = $prevMonth[$count - $i][$dayIndex];               
            } else {
                $weekday = Calendar::$days[$prevMonth[$count - $i]][$this->language];            
                $output['-' . ($count - $i)][$weekday] = [];               
            }           
        }        
        return $output;
    }
    public function getFollowingDays(array $nextMonth, int $month) : array
        {        
        $output = [];        
        $lastDay = $this->calendar->getLastDayOfMonth($month);
        $diff =  7 - $lastDay;
        for ($i = 1; $i <= $diff ; $i++) {            
            if (is_array($nextMonth[$i])) {
                $dayIndex = key($nextMonth[$i]);   
                $weekday = Calendar::$days[$dayIndex][$this->language]; 
                $output['+' . ($i)][$weekday] = $nextMonth[$i][$dayIndex];               
            } else {
                $weekday = Calendar::$days[$nextMonth[$i]][$this->language];            
                $output['+' . ($i)][$weekday] = [];               
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