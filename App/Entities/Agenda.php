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
    private array $lastYear;
    private array $nextYear;
    
    public function __construct(Calendar $calendar, string $language = null)
    {
        $this->calendar = $calendar;
        $this->language = $language ?? 'en';
        $this->agenda = $calendar->show();
        $last = new Calendar($this->getYear() - 1);
        $next = new Calendar($this->getYear() + 1);
        $this->lastYear = $last->show();         
        $this->nextYear = $next->show();
    }    
    public function addNote(string $label, int $day, int $month, string $note)
    {         
        $agenda = $this->getContent($label);
        if (!is_array($agenda[$month][$day])) {
            $weekday = $agenda[$month][$day];                 
            $agenda[$month][$day] = [$weekday => []];                  
        }
        $weekday = key($agenda[$month][$day]);
        $agenda[$month][$day][$weekday][time()] = $note;
        $agenda = $this->setContent($label, $agenda);  
    }
    public function removeNote(string $label, int $day, int $month, string $timestamp)
    { 
        $agenda = $this->getContent($label);
       
        if (!is_array($agenda[$month][$day])) {
            throw new NoNotesFoundForThisDayException();
        }        
        $weekday = key($agenda[$month][$day]);
        if (isset($agenda[$month][$day][$weekday][$timestamp])) {
            unset($agenda[$month][$day][$weekday][$timestamp]);                     
        } else {
            throw new NoteDoesNotExistException();
        }
        
        if (empty($agenda[$month][$day][$weekday])) {
            $agenda[$month][$day] = $weekday;
        }        
        
        $agenda = $this->setContent($label, $agenda);   
    }   

    /* getters */
    public function getContent(string $label) : array
    {        
        if ($label === 'last') {
            return $this->lastYear;
        }
        if ($label === 'next') {
            return $this->nextYear;
        }
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
    public function showAgenda(bool $trailingDays = null) /*: array*/
    { 
        $output = [];
        $agenda = $this->agenda;
        
        foreach ($agenda as $monthNumber => $days) {                       
            $monthName = Calendar::$months[intval($monthNumber)][$this->language];
            
            //l> trailing days before                      
            if ($trailingDays) {
                $previousMonth = $monthNumber === 1 
                    ? $this->lastYear[12]
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
                    ? $this->nextYear[1]
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
    public function setContent(string $label, array $content)
    {
        if ($label === 'last') {
            $this->lastYear = $content;
        }elseif ($label === 'next') {
            $this->nextYear = $content;
        }else {
            $this->agenda = $content;
        }      
    }
    public function setLastYear(array $year)
    {
        $this->lastYear = $year;
    }
    public function setNextYear(array $year)
    {        
        $this->nextYear = $year;
    }
}