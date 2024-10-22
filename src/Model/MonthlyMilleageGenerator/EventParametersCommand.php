<?php
namespace App\Model\MonthlyMilleageGenerator;
use App\Entity\CompanyEntity;
use App\Entity\PersonEntity;
use App\Entity\VehicleEntity;
use DateTime;
use Symfony\Component\Yaml\Yaml;

class EventParametersCommand extends EventParameters{


    static private string $yamlFilePath = __DIR__ . '/../../data/HeaderDataToPrint.yaml';



    public function __construct($parsedArgs)
    {
        $this->mileageStart = (int)$parsedArgs['mileage_start'];
        $this->mileageEnd = (int)$parsedArgs['mileage_end'];
        $this->dateStart = new DateTime($parsedArgs['date_start']);
        $this->dateEnd = new DateTime($parsedArgs['date_end']);
        $this->tolerance = isset($parsedArgs['tolerance']) ? (int)$parsedArgs['tolerance'] : 300;
        $this->maxTolerance = isset($parsedArgs['tolerance_max']) ? (int)$parsedArgs['tolerance_max'] : 1600;

        $data = Yaml::parseFile(self::$yamlFilePath);

        $this->company = new CompanyEntity(
            $data['Company']['name'],
            $data['Company']['nip'],
            $data['Company']['address']
        );

        $this->person = new PersonEntity(
            $data['Person']['forename'],
            $data['Person']['surname'],
            $data['Person']['adress']
        );

        $this->vehicle = new VehicleEntity(
            $data['Vehicle']['brand'],
            $data['Vehicle']['model'],
            $data['Vehicle']['year'],
            $data['Vehicle']['registration_number'],
            $data['Vehicle']['vin'],
            $data['Vehicle']['engin_capacity']
        );
    }
}
