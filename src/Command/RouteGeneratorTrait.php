<?php

namespace App\Command;

use App\Model\Print\HtmlTemplate1;
use App\Model\Report\ReportFactory;
use App\Model\Routes\RouteList;
use App\Model\Routes\RoutesGenerator;

trait RouteGeneratorTrait
{
    /**
     * @throws \Exception
     */
    private function generateRoutes(string $year, string $month, int $distanceApproximate, int $distanceStart): RouteList
    {
        $racesGenerator = new RoutesGenerator(
            new RouteList(
                $year,
                $month,
                $distanceStart
            ),
            $distanceApproximate
        );
        return $racesGenerator->getRoutes();
    }



    private function printReport(RouteList $routeReport): void
    {
        $reportEntity = ReportFactory::mapTracesListToYamlConfiguration($routeReport);
        $html = new HtmlTemplate1($reportEntity);
        $html->print($reportEntity->meta->year, $reportEntity->meta->month);

        foreach ($reportEntity->routeList->routes as $route) {
            echo $route->date->format('Y-m-d') . " - Trasa: " . $route->destination . " (" . $route->distance . " km)\n";
        }
        echo $reportEntity->routeList->mileCounter . " km\n";
    }
}