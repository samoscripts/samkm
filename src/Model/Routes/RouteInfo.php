<?php

namespace App\Model\Routes;

use DateTime;
class RouteInfo
{


    public int $distance = 0;

    public string $destination;

    public string $routeDescription;

    /**
     * @param RouteDetails[] $races
     */
    public array $routeDetailsList;
    public function __construct(
        array           $routeArray,
        public DateTime $journalDate
    )
    {
        $routeDetailsList = array_map(fn($route) => new RouteDetails($route), $routeArray['traceDetails']);
        foreach($routeDetailsList as $traceDetail) {
            $this->distance += $traceDetail->distance;
        }
        $this->destination = $routeArray['destination'];
        $this->routeDescription = $routeArray['traceDescription'];
        $this->routeDetailsList = $routeDetailsList;

    }
}