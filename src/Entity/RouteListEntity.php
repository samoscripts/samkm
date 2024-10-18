<?php

namespace App\Entity;

use App\Model\Routes\RouteList;

class RouteListEntity
{
    /**
     * @var RouteEntity[]
     */
    public array $routes;

    public int $mileCounter = 0;

    /**
     * @param RouteList $routeList
     */
    public function __construct(
        RouteList $routeList
    ) {
        $this->mileCounter = $routeList->getMileCounter();
        $i = 0;
        foreach ($routeList->routesGroupedByDate as $routeInfo) {
            $i++;
            $this->routes[] = new RouteEntity(
                $i,
                $routeInfo->journalDate,
                $routeInfo->routeDescription,
                $routeInfo->destination,
                $routeInfo->distance,
                ''
            );

        }
    }
}