<?php

namespace App\Model\Report;

use App\Entity\MetaEntity;
use App\Entity\RouteListEntity;
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
        RouteList $routeList
    ): ReportEntity
    {
        $data = Yaml::parseFile(self::$yamlFilePath);

        $company = new CompanyEntity(
            $data['Company']['name'],
            $data['Company']['nip'],
            $data['Company']['address']
        );

        $person = new PersonEntity(
            $data['Person']['forename'],
            $data['Person']['surname'],
            $data['Person']['adress']
        );

        $vehicle = new VehicleEntity(
            $data['Vehicle']['brand'],
            $data['Vehicle']['model'],
            $data['Vehicle']['year'],
            $data['Vehicle']['registration_number'],
            $data['Vehicle']['vin'],
            $data['Vehicle']['engin_capacity']
        );

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