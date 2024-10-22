<?php

namespace App\Model\Report;

use App\Entity\MetaEntity;
use App\Entity\RouteListEntity;
use App\Model\MonthlyMilleageGenerator\EventParameters;
use App\Model\Routes\RouteList;
use Symfony\Component\Yaml\Yaml;
use App\Entity\CompanyEntity;
use App\Entity\PersonEntity;
use App\Entity\VehicleEntity;
use App\Entity\ReportEntity;

class ReportFactory
{
    static private string $yamlFilePath = __DIR__ . '/../../data/HeaderDataToPrint.yaml';
    public static function mapTracesListToYamlConfiguration(
        RouteList $routeList,
        EventParameters $data
    ): ReportEntity
    {
        $company = $data->company;
        $person = $data->person;
        $vehicle = $data->vehicle;

        $metaEntity = new MetaEntity(
            $routeList->year,
            $routeList->month,
            $routeList->mileageCounterInitial,
            $routeList->mileageCounterFinal,
            $routeList->getMileCounter()
        );

        $routeList = new RouteListEntity($routeList);

        return new ReportEntity(
            $metaEntity,
            $company,
            $person,
            $vehicle,
            $routeList
        );
    }
}