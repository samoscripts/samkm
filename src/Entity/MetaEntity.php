<?php

namespace App\Entity;

class MetaEntity
{
    const RATES = [
        '2016' => 0.8358,
        '2017' => 0.8358,
        '2018' => 0.8358,
        '2019' => 0.8358,
        '2020' => 0.8358,
        '2021' => 0.8358,
        '2022' => 0.8358,
        '2023' => 1.15,
        '2024' => 1.15
    ];

    private const MONTHS_PL = [
        'January' => 'Styczeń',
        'February' => 'Luty',
        'March' => 'Marzec',
        'April' => 'Kwiecień',
        'May' => 'Maj',
        'June' => 'Czerwiec',
        'July' => 'Lipiec',
        'August' => 'Sierpień',
        'September' => 'Wrzesień',
        'October' => 'Październik',
        'November' => 'Listopad',
        'December' => 'Grudzień'
    ];

    public string $mileageStartDate;
    public string $mileageEndDate;
    public string $monthName;
    public float $rate;

    public function __construct(
        public string $year,
        public string $month,
        public int    $mileageCounterInitial,
        public int    $mileageCounterFinal,
        public int    $mileageCounter
    ) {
        $this->rate = self::RATES[$year];
        $this->mileageStartDate = $this->year . '-' . $this->month . '-01';
        $this->mileageEndDate = $this->year . '-' . $this->month . '-' . date('t', strtotime($this->mileageStartDate));
        $englishMonthName = date('F', strtotime($this->mileageStartDate));
        $this->monthName = self::MONTHS_PL[$englishMonthName];
    }
}