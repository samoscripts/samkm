<?php

namespace App\Model\Routes;

use App\Model\WorkingDays\WorkingDays;

/**
 * @param RouteDetails[] $races
 */
class RouteList
{
    /**
     * @var RouteInfo[] $routesGroupedByDate
     */
    public $routesGroupedByDate = [];

    public int $mileageCounterFinal;

    /**
     * Liczba przejechanych kilometrów w danym miesiącu
     */
    private int $mileCounter = 0;

    public function __construct(
        public string $year,
        public string $month,
        public readonly int $mileageCounterInitial
    )
    {
        WorkingDays::setWorkingDays($this->year, $this->month);
    }

    public function appendRoute(array $routeArray)
    {
        $routeInfo = new RouteInfo($routeArray, WorkingDays::popupRandomDay());
        $this->mileCounter += $routeInfo->distance;
        $this->routesGroupedByDate[] = $routeInfo;
    }

    public function getMileCounter(): int
    {
        return $this->mileCounter;
    }

    /**
     * @param int $mileageCounterFinal
     */
    public function setMileageCounterFinal(): void
    {
        $this->mileageCounterFinal = $this->mileageCounterInitial+$this->mileCounter;
    }
}