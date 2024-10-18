<?php

namespace App\Entity;

class ReportEntity
{
    public function __construct(
        public MetaEntity      $meta,
        public CompanyEntity   $company,
        public PersonEntity    $person,
        public VehicleEntity   $vehicle,
        public RouteListEntity $routeList
    ) {}
}
