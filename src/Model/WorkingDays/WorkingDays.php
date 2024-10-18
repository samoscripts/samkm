<?php

namespace App\Model\WorkingDays;
use App\Model\ArrayUtils;
use DateTime;

class WorkingDays
{
    static private array $days = [];

    public static function popupRandomDay(): DateTime
    {
        if(empty(self::$days)) {
            throw new \RuntimeException('Working days are empty');
        }
        // Implementation of the popup method
        return ArrayUtils::popRandomValue(self::$days);
    }

    public static function popupRandomDayRange($dayFrom, $dayTo)
    {
        // Implementation of the popup method
        return ArrayUtils::popRandomValue(self::$days);
    }

    public static function setWorkingDays(string $year, string $month)
    {
        self::$days = self::generateWorkingDays($year, $month);
    }

    private static function generateWorkingDays(string $year, string $month)
    {
        $freeWorkingDays = new WorkingDaysGenerator($year, $month);
        return $freeWorkingDays->getWorkingDays();

    }
}