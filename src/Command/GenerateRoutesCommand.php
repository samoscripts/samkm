<?php
namespace App\Command;

use App\Model\Print\HtmlTemplate1;
use App\Model\Report\ReportFactory;
use App\Model\Routes\RouteList;
use App\Model\Routes\RoutesGenerator;
use Symfony\Component\Yaml\Yaml;

class GenerateRoutesCommand extends CommandAbstract
{
    use RouteGeneratorTrait;
    public function __construct()
    {
        $this->setName('generate:routes')
            ->setShortcut('gr')
            ->setDescription('Generuje zestawienie tras na podstawie podanej liczby kilometrów i miesiąca')
            ->addOption(
                [
                    'name' => 'year_month',
                    'required' => true,
                    'shortcut' => 'ym',
                    'description' => 'Data raportu w formacie YYYY-MM',
                    'validate' => 'pattern:/^\d{4}-\d{2}$/'
                ]
            )
            ->addOption(
                [
                    'name' => 'distance',
                    'required' => true,
                    'shortcut' => 'd',
                    'description' => 'Liczba kilometrów przejechanych we wskazanym miesiącu.',
                    'validate' => 'is_numeric'
                ]
            )
            ->addOption(
                [
                    'name' => 'distanceStart',
                    'required' => true,
                    'shortcut' => 'ds',
                    'description' => 'Stan początkowy licznika kilometrów pojazdu w danym miesiącu',
                    'validate' => 'is_numeric'
                ]
            );
    }

    /**
     * @throws \Exception
     */
    public function execute(array $args): void
    {
        if ($this->handleInfoOption($args)) {
            return;
        }
        $parsedArgs = $this->parseOptions($args);
        $this->validateOptions($parsedArgs);

        $yearMonth = $parsedArgs['year_month'];
        $distance = (int)$parsedArgs['distance'];
        $distanceStart = (int)$parsedArgs['distanceStart'];


        [$year, $month] = $this->extractYearMonth($yearMonth);

        $routeReport = $this->generateRoutes(
            $year,
            $month,
            $distance,
            $distanceStart
        );
        $this->printReport($routeReport);
    }

    private function parseMonthlyMileageYamlFile(): array
    {
        $yamlContent = file_get_contents(__DIR__ . '/../data/MonthlyMileage.yaml');
        return Yaml::parse($yamlContent);
    }

    private function extractYearMonth(string $yearMonth): array
    {
        return explode('-', $yearMonth);
    }
}