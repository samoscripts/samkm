<?php

namespace App\Model\Routes;

use App\Model\ArrayUtils;

class RouteDetails
{

    public int $distance;

    public string $name;

    public string $destinationFrom;

    public string $destinationTo;

    public string $description;

    public string $destination;
    public function __construct(
        array $routeArrayValue
    )
    {
        $option = ArrayUtils::getRandomValue($routeArrayValue['routeOptions']);
        $this->distance = $option['distance'];
        $this->destinationFrom = $routeArrayValue['from'];
        $this->destinationTo = $routeArrayValue['to'];
        $this->description = $this->destinationFrom . ' - ' . $this->destinationTo .'  (' . $option['name'] . ')';
        $this->name = $option['name'];
    }

}