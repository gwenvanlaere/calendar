<?php
//Entities/Calendar.php
declare(strict_types=1);

namespace App\Entities;

class Calendar
{
    public static array $languages = ['en', 'nl'];
    public static array $days = [
        1 => ['en' => 'monday', 'nl' => 'maandag'], 
        2 => ['en' => 'tuesday', 'nl' => 'dinsdag'],         
        3 => ['en' => 'wednesday', 'nl' =>'woensdag'], 
        4 => ['en' => 'thursday', 'nl' =>'donderdag'], 
        5 => ['en' => 'friday', 'nl' =>'vrijdag'], 
        6 => ['en' => 'saturday', 'nl' =>'zaterdag'], 
        7 => ['en' => 'sunday', 'nl' =>'zondag'],
    ];
    public static array $months = [
        1 => ['en' => 'january', 'nl' => 'januari'],
        2 => ['en' => 'february', 'nl' => 'februari'],
        3 => ['en' => 'march', 'nl' => 'maart'],
        4 => ['en' => 'april', 'nl' => 'april'],
        5 => ['en' => 'may', 'nl' => 'mei'],
        6 => ['en' => 'june', 'nl' => 'juni'],
        7 => ['en' => 'july', 'nl' => 'juli'],
        8 => ['en' => 'august', 'nl' => 'augustus'],
        9 => ['en' => 'september', 'nl' => 'september'],
        10 => ['en' => 'october', 'nl' => 'oktober'],
        11 => ['en' => 'november', 'nl' => 'november'],
        12 => ['en' => 'december', 'nl' => 'december'], 
    ];
    private string $language;
    private int $year;
    private array $calendar;
    
    public function __construct(int $year = null)
    {              
        $year = $year ?? intval(date("Y"));
        $this->year = $year; 
        $this->init();        
    }
    
    /* private methods */
    private function init() /*: array*/
    {  
        $calendar = $this->makeCalendarMonths();       
        $this->calendar = $calendar;
    }    
    private function makeCalendarMonths()
    {        
        $calendarMonths = [];
        foreach(self::$months as $month => $name) {
            $calendarMonths += [$month => $this->makeCalendarDays($month)];
        }
        return $calendarMonths;       
    }      
    private function makeCalendarDays(int $month) : array
    {        
        $daysInMonth = $this->getDaysInMonth($month);
        $start = $this->getFirstDayOfMonth($month);        
        $calendarDays = [];        
        for ($i=1; $i <= $daysInMonth; $i++) {
            $start = $start > 7 ? 1 : $start;           
            $calendarDays += [$i => $start];
            $start++;
        }
        return $calendarDays;
    }    
    public function getFirstDayOfMonth(int $month) : int
    { 
        $timestamp = strtotime(strval($this->year) . '-'. strval($month) . '-01');
        $day = intval(date('w', $timestamp));
        return $day === 0 ? 7 : $day; /* sunday = 0 */
    }
    public function getLastDayOfMonth(int $month) : int 
    {
        $timestamp = strtotime(strval($this->year) . '-'. strval($month) . '-' . strval($this->getDaysInMonth($month)));
        $day = intval(date('w', $timestamp));
        return $day === 0 ? 7 : $day; /* sunday = 0 */
    }
    public function getDecemberOfLastYear() : array 
    {
        $this->year--;
        $month = $this->makeCalendarDays(12);
        $this->year++;
        return $month;
    }
    public function getJanuaryOfNextYear() : array 
    {
        $this->year++;
        $month = $this->makeCalendarDays(1);
        $this->year--;
        return $month;
    }

    /* getters */    
    public function getYear() : int
    {
        return $this->year;
    }
   
    public function show() : array
    {        
        return $this->calendar;
    }
    public function getDay(int $day, int $month)
    {       
        return $this->calendar[self::$months[$month][$this->language]][$day];
    }
    public function getDaysInMonth(int $month) : int
    {
        $year = $this->year;
        $daysInMonth = $month === 2 
            ? ($year % 4 
                ? 28 
                : ($year % 100 
                ? 29 
                : ($year % 400 
                ? 28 : 29))) 
            : (($month - 1) % 7 % 2 
            ? 30 : 31);
        return $daysInMonth;
    }
}