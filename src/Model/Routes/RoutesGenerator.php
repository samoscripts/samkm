<?php

namespace App\Model\Routes;

use App\Model\ArrayUtils;
use Symfony\Component\Yaml\Yaml;

class RoutesGenerator
{
    private array $routes;
    static private int $distanceTolerance = 30;

    public int $distanceEnd;
    public function __construct(
        private RouteList $routeList,
        private readonly int $distanceApproximate
    )
    {
        $this->routes = Yaml::parseFile(__DIR__ . '/Data/traces.yaml');
    }

    /**
     * @throws \Exception
     */
    public function getRoutes(): RouteList
    {
        while ($this->routeList->getMileCounter() <= ($this->distanceApproximate - self::$distanceTolerance)) {
            $routeArray = $this->getRandomRoute();
            $this->routeList->appendRoute($routeArray);
            $this->checkIfRoutesEmpty();
        }
        $this->routeList->setMileageCounterFinal();
        $this->sortRouteListByDate($this->routeList);
        return $this->routeList;
    }

    private function getRandomRoute(): array
    {
        $routeKey = ArrayUtils::getRandomKey($this->routes['races']);
        $routeArray = $this->routes['races'][$routeKey];
        if (--$routeArray['frequency'] <= 0) {
            unset($this->routes['races'][$routeKey]);
        }
        return $routeArray;
}
    private function checkIfRoutesEmpty(): void
    {
        if (empty($this->routes['races'])) {
            throw new \Exception("Przekroczono dozwoloną liczbę tras");
        }
    }




    private function sortRouteListByDate(RouteList &$races): void
    {
        usort($races->routesGroupedByDate, function (RouteInfo $a, RouteInfo $b) {
            return $a->journalDate <=> $b->journalDate;
        });
    }
}