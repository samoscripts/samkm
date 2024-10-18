<?php
namespace App\Model\WorkingDays;
class WorkingDaysGenerator
{
    const array PUBLIC_HOLIDAYS = [
        '01-01', // New Year's Day
        '01-06', // Epiphany
        '05-01', // Labour Day
        '05-03', // Constitution Day
        '08-15', // Assumption of Mary
        '11-01', // All Saints' Day
        '11-11', // Independence Day
        '12-25', // Christmas Day
        '12-26', // Second Day of Christmas
    ];

    private string $year;

    private string $month;

    private string $easterDate;

    private array $daysOff;

    public function __construct(string $year, string $month)
    {
        $this->year = $year;
        $this->month = $month;
        $this->easterDate = date('Y-m-d', easter_date($this->year));
        $this->setDaysOff();
    }

    public function getWorkingDays()
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $workingDays = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = date('Y-m-d', strtotime("$this->year-$this->month-$i"));
            if (!in_array($date, $this->daysOff)) {
                $workingDays[] = new \DateTime($date);
            }
        }

        return $workingDays;

    }

    private function getFloatingDaysOff(): array
    {
        $easterFreeDays = [
            $this->getEasterMonday(),
            $this->getCorpusChristi(),
            $this->getPentecost()
        ];

        return $easterFreeDays;
    }

    /**
     * Zwraca datę poniedziałku wielkanocnego
     */
    private function getEasterMonday(): string
    {
        return date('Y-m-d', strtotime($this->easterDate . ' +1 day'));
    }

    /**
     * Zwraca datę Bożego Ciała
     */
    private function getCorpusChristi(): string
    {
        return date('Y-m-d', strtotime($this->easterDate . ' +60 days'));
    }

    /**
     * Zwraca datę Zielonych Świątek
     */
    private function getPentecost(): string
    {
        return date('Y-m-d', strtotime($this->easterDate . ' +49 days'));
    }

    private function setDaysOff(): void
    {
        $this->daysOff = array_merge(
            $this->getPublicHolidays(),
            $this->getFloatingDaysOff(),
            $this->getWeekendDays()
        );
    }

    private function getWeekendDays()
    {
        $days = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $weekendDays = [];

        for ($i = 1; $i <= $days; $i++) {
            $date = date('Y-m-d', strtotime("$this->year-$this->month-$i"));
            $dayOfWeek = date('N', strtotime($date));
            if ($dayOfWeek >= 6) {
                $weekendDays[] = $date;
            }
        }

        return $weekendDays;
    }

    private function getPublicHolidays()
    {
        $publicHolidays = [];

        foreach (self::PUBLIC_HOLIDAYS as $publicHoliday) {
            $publicHolidays[] = $this->year . '-' . $publicHoliday;
        }

        return $publicHolidays;
    }
}