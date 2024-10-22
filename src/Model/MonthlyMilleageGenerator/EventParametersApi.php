<?php

namespace App\Model\MonthlyMilleageGenerator;

use App\Entity\CompanyEntity;
use App\Entity\PersonEntity;
use App\Entity\VehicleEntity;
use DateTime;

class EventParametersApi extends EventParameters
{


    public function __construct($parsedArgs)
    {
        $this->mileageStart = (int)$parsedArgs['mileage_start'];
        $this->mileageEnd = (int)$parsedArgs['mileage_end'];
        $this->dateStart = new DateTime($parsedArgs['date_start']);
        $this->dateEnd = new DateTime($parsedArgs['date_end']);
        $this->tolerance = isset($parsedArgs['tolerance']) ? (int)$parsedArgs['tolerance'] : 300;
        $this->maxTolerance = isset($parsedArgs['tolerance_max']) ? (int)$parsedArgs['tolerance_max'] : 1600;

        $this->company = new CompanyEntity(
            $parsedArgs['company_name'],
            $parsedArgs['nip'],
            $parsedArgs['address']
        );

        $this->person = new PersonEntity(
            $parsedArgs['forename'],
            $parsedArgs['surname'],
            $parsedArgs['address']
        );

        $this->vehicle = new VehicleEntity(
            $parsedArgs['vehicle_brand'],
            $parsedArgs['vehicle_model'],
            $parsedArgs['vehicle_year'],
            $parsedArgs['registration_number'],
            $parsedArgs['vin'],
            $parsedArgs['engine_capacity']
        );
    }
}
