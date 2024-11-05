<?php
namespace App\Model\MonthlyMilleageGenerator;
use App\Entity\CompanyEntity;
use App\Entity\PersonEntity;
use App\Entity\VehicleEntity;
use DateTime;
use Symfony\Component\Yaml\Yaml;

class EventParametersCommand extends EventParameters{


    static private string $yamlVehicleFilePath = BASE_DIR . '/src/data/DefaultVehicleData.yaml';
    static private string $yamlOwnerFilePath = BASE_DIR . '/src/data/DefaultOwnerData.yaml';



    public function setParameters($parsedArgs): void
    {
        $this->mileageStart = (int)$parsedArgs['mileage_start'];
        $this->mileageEnd = (int)$parsedArgs['mileage_end'];
        $this->dateStart = new DateTime($parsedArgs['date_start']);
        $this->dateEnd = new DateTime($parsedArgs['date_end']);
        $this->tolerance = isset($parsedArgs['tolerance']) ? (int)$parsedArgs['tolerance'] : 300;
        $this->maxTolerance = isset($parsedArgs['tolerance_max']) ? (int)$parsedArgs['tolerance_max'] : 1600;

        $defaultVehicleData = Yaml::parseFile(self::$yamlVehicleFilePath);
        $defaultOwnerData = Yaml::parseFile(self::$yamlOwnerFilePath);

        $this->company = new CompanyEntity(
            $defaultOwnerData['Company']['name'],
            $defaultOwnerData['Company']['nip'],
            $defaultOwnerData['Company']['address']
        );

        $this->person = new PersonEntity(
            $defaultOwnerData['Person']['forename'],
            $defaultOwnerData['Person']['surname'],
            $defaultOwnerData['Person']['adress']
        );

        $this->vehicle = new VehicleEntity(
            $defaultVehicleData['Vehicle']['brand'],
            $defaultVehicleData['Vehicle']['model'],
            $defaultVehicleData['Vehicle']['year'],
            $defaultVehicleData['Vehicle']['registration_number'],
            $defaultVehicleData['Vehicle']['vin'],
            $defaultVehicleData['Vehicle']['engin_capacity']
        );
    }
}
