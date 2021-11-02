<?php
//Business/AdresService.php
declare(strict_types=1);

namespace App\Business;

class CalendarService
{
    public function makeCalendar(int $year) 
    {
        return 'this is the year: ' . $year;
    }
}