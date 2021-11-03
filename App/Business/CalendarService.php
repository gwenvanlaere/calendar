<?php
//Business/CalendarService.php
declare(strict_types=1);

namespace App\Business;

use App\Entities\Calendar;
use Exceptions\InvalidYearException;
use Exceptions\LanguageNotSupported;

class CalendarService
{
    public function makeCalendar(int $year = null, string $language = null) : Calendar
    {        
        if ($year) {
            if ($year > 3000 || $year < 1000) {
                throw new InvalidYearException();
            }
        }
        if ($language) {
            if (!in_array($language, Calendar::$languages)) {
                throw new LanguageNotSupported();            
            }
        }
        $calendar = new Calendar($year, $language);        
        return $calendar;
    }
}