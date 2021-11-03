<?php
//Business/CalendarService.php
declare(strict_types=1);

namespace App\Business;

use App\Entities\Calendar;
use App\Exceptions\InvalidYearException;

class CalendarService
{
    public function makeCalendar(int $year = null) : Calendar
    {        
        if ($year) {
            if ($year > 3000 || $year < 1000) {
                throw new InvalidYearException();
            }
        }
        
        $calendar = new Calendar($year);        
        return $calendar;
    }
}