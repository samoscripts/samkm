<?php
namespace App\Model\MonthlyMilleageGenerator;
use App\Entity\CompanyEntity;
use App\Entity\PersonEntity;
use App\Entity\VehicleEntity;
use DateTime;

class EventParameters
{

    public int $mileageStart;
    public int $mileageEnd;
    public DateTime $dateStart;
    public DateTime $dateEnd;
    public int $tolerance;
    public int $maxTolerance;
    public CompanyEntity $company;
    public PersonEntity $person;
    public VehicleEntity $vehicle;
}