<?php

namespace App\Entity;

class VehicleEntity
{
    public function __construct(
        public string $brand,
        public string $model,
        public int $year,
        public string $registration_number,
        public string $vin,
        public string $engine_capacity
    ) {}
}