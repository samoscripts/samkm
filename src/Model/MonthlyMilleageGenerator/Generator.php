<?php

namespace App\Model\MonthlyMilleageGenerator;

use App\Model\Print\HtmlTemplate1;
use App\Model\Report\ReportFactory;
use App\Model\Routes\RouteList;
use App\Model\Routes\RoutesGenerator;
use DateTime;

class Generator
{
    public function __construct(private EventParameters $eventParameters)
    {
    }

    public function generateMonthlyMileage(): void
    {
        $this->flushTmp();

        $totalMonths = $this->calculateTotalMonths();
        $averageKilometersPerMonth = $this->calculateAverageKilometersPerMonth($totalMonths);

        $monthlyMileage = $this->generateMileageArray($totalMonths, $averageKilometersPerMonth);
        $mileageStart = $this->eventParameters->mileageStart;
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
            $this->printReport($routeReport);
        }

//        foreach ($routeReports as $routeReport) {
//            $pid = pcntl_fork();
//            if ($pid == -1) {
//                die('nie udało się utworzyć procesu');
//            } elseif ($pid) {
//                continue;
//            } else {
//                $this->printReport($routeReport, $eventParameters);
//                exit(0);
//            }
//        }
    }

    private function flushTmp()
    {
        $files = glob(BASE_DIR . '/tmp/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

    }

    private function printReport(RouteList $routeReport): void
    {
        $reportEntity = ReportFactory::mapTracesListToYamlConfiguration($routeReport, $this->eventParameters);
        $html = new HtmlTemplate1($reportEntity);
        $html->print($reportEntity->meta->year, $reportEntity->meta->month);

//        foreach ($reportEntity->routeList->routes as $route) {
//            echo $route->date->format('Y-m-d') . " - Trasa: " . $route->destination . " (" . $route->distance . " km)\n";
//        }
//        echo $reportEntity->routeList->mileCounter . " km\n";
    }
    /**
     * @throws \Exception
     */
    private function generateRoutes(string $year, string $month, int $distanceApproximate, int $distanceStart): RouteList
    {
        $racesGenerator = new RoutesGenerator(
            new RouteList(
                $year,
                $month,
                $distanceStart
            ),
            $distanceApproximate
        );
        return $racesGenerator->getRoutes();
    }

    private function calculateTotalMonths(): int
    {
        ;
        $interval = $this->eventParameters->dateStart->diff($this->eventParameters->dateEnd);
        return ($interval->y * 12) + $interval->m + 1; // +1 to include the end month
    }

    private function calculateAverageKilometersPerMonth(int $totalMonths): int
    {
        $totalKilometers = $this->eventParameters->mileageEnd - $this->eventParameters->mileageStart;
        return round($totalKilometers / $totalMonths);
    }

    private function generateMileageArray(int $totalMonths, float $averageKilometersPerMonth): array
    {
        $monthlyMileage = [];
        $currentMileage = $this->eventParameters->mileageStart;

        for ($i = 0; $i < $totalMonths; $i++) {
            $month = (clone $this->eventParameters->dateStart)->modify("+{$i} months");
            $variation = rand(-$this->eventParameters->tolerance, $this->eventParameters->tolerance);
            $monthlyKilometers = $averageKilometersPerMonth + $variation;

            if ($monthlyKilometers > $this->eventParameters->maxTolerance) {
                $monthlyKilometers = $this->eventParameters->maxTolerance - rand(11, 99);
            }

            if ($i == $totalMonths - 1) {
                $monthlyKilometers = $this->eventParameters->mileageEnd - $currentMileage;
            }
            if ($monthlyKilometers > $this->eventParameters->maxTolerance) {
                throw new \Exception('Miesięczny przebieg przekracza maksymalną dopuszczalną wartość. Spróbuj ponownie albo zmień parametry wejściowe.' . $monthlyKilometers);
            }

            $currentMileage += $monthlyKilometers;
            $monthlyMileage[$month->format('Y-m')] = [
                'mileage' => $monthlyKilometers,
                'mileageStart' => $currentMileage - $monthlyKilometers,
                'mileageEnd' => $currentMileage,
                'year' => $month->format('Y'),
                'month' => $month->format('m')
            ];
        }

        return $monthlyMileage;
    }
}