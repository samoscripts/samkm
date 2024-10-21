<?php
namespace App\Command;

use App\Model\MonthlyMilleageGenerator\Generator;
use Symfony\Component\Yaml\Yaml;

class GenerateMonthlyMileageCommand extends CommandAbstract
{
    use RouteGeneratorTrait;
    public function __construct()
    {
        $this->setName('generate:monthly:mileage')
            ->setShortcut('gmm')
            ->setDescription('Generuje miesięczne przebiegi dla pojazdu')
            ->addOption([
                'name' => 'mileage_start',
                'shortcut' => 'ms',
                'required' => true,
                'description' => 'Stan początkowy licznika przebiegu pojazdu',
                'validate' => 'is_numeric'
            ])
            ->addOption([
                'name' => 'mileage_end',
                'shortcut' => 'me',
                'required' => true,
                'description' => 'Stan końcowy licznika przebiegu pojazdu',
                'validate' => 'is_numeric'
            ])
            ->addOption([
                'name' => 'date_start',
                'shortcut' => 'ds',
                'required' => true,
                'description' => 'Data początkowa w formacie YYYY-MM',
                'validate' => 'pattern:/^\d{4}-\d{2}$/'
            ])
            ->addOption([
                'name' => 'date_end',
                'shortcut' => 'de',
                'required' => true,
                'description' => 'Data końcowa w formacie YYYY-MM',
                'validate' => 'pattern:/^\d{4}-\d{2}$/'
            ])
            ->addOption([
                'name' => 'tolerance_max',
                'shortcut' => 'tm',
                'required' => false,
                'description' => 'Maksymalna tolerancja dla zmian przebiegu (domyślnie 1600 km) - Jeżeli zostanie przekroczona '
                    . 'dla danego miesiąca - zostanie ustawiona maksymalna wartość (minus randomowa wartość od 11 do 99)',
                'validate' => 'is_numeric'
            ])
            ->addOption([
                'name' => 'tolerance',
                'shortcut' => 't',
                'required' => false,
                'description' => 'Tolerancja dla zmian przebiegu (domyślnie 300 km). Jeżeli średnia dla każdego miesiąca wynosi '
                    . '1400 km, a tolerancja wynosi 300 km, to dla każdego miesiąca zostanie wylosowana wartość z zakresu '
                    . '1100-1700 km',
                'validate' => 'is_numeric'
            ])
            ->addOption([
                'name' => 'generate',
                'shortcut' => 'g',
                'required' => false,
                'description' => 'Generuje przebiegi dla pojazdu w PDF. Parametr przyjmuje wartość pdf|html|txt',
                'validate' => 'pattern:/pdf|html|txt/'
            ]);


    }
    public function execute(array $args): void
    {
        if ($this->handleInfoOption($args)) {
            return;
        }

        $parsedArgs = $this->parseOptions($args);
        $this->validateOptions($parsedArgs);

        $mileageStart = (int)$parsedArgs['mileage_start'];
        $mileageEnd = (int)$parsedArgs['mileage_end'];
        $dateStart = $parsedArgs['date_start'];
        $dateEnd = $parsedArgs['date_end'];
        $tolerance = isset($parsedArgs['tolerance']) ? (int)$parsedArgs['tolerance'] : 300;
        $maxTolerance = isset($parsedArgs['tolerance_max']) ? (int)$parsedArgs['tolerance_max'] : 1600;
        $generatePdf = isset($parsedArgs['generate']);

        $generator = new Generator($mileageStart, $mileageEnd, $dateStart, $dateEnd, $tolerance, $maxTolerance);
        $monthlyMileage = $generator->generateMonthlyMileage();

        foreach ($monthlyMileage as $month => $mileageData) {
            echo "{$month}: {$mileageData['mileage']} km\n";
        }
        if($generatePdf) {
            foreach ($monthlyMileage as $mileageData) {
                $routeReport = $this->generateRoutes(
                    $mileageData['year'],
                    $mileageData['month'],
                    $mileageData['mileage'],
                    $mileageStart
                );
                $mileageStart = $routeReport->mileageCounterFinal;
                $routeReports[] = $routeReport;


            }

            foreach ($routeReports as $routeReport) {
                $pid = pcntl_fork();
                if ($pid == -1) {
                    die('nie udało się utworzyć procesu');
                } elseif ($pid) {
                    continue;
                } else {
                    $this->printReport($routeReport);
                    exit(0);
                }
            }



        }
    }
}