<?php

namespace App\Model\MonthlyMilleageGenerator;

use DateTime;

class Generator
{
    public function __construct(
        private int    $startMileage,
        private int    $endMileage,
        private string $startDate,
        private string $endDate,
        private int    $tolerance = 300,
        private int    $maxTolerance = 1600
    )
    {
    }

    public function generateMonthlyMileage(): array
    {
        $totalMonths = $this->calculateTotalMonths();
        $averageKilometersPerMonth = $this->calculateAverageKilometersPerMonth($totalMonths);

        return $this->generateMileageArray($totalMonths, $averageKilometersPerMonth);
    }

    private function calculateTotalMonths(): int
    {
        $start = new DateTime($this->startDate);
        $end = new DateTime($this->endDate);
        $interval = $start->diff($end);
        return ($interval->y * 12) + $interval->m + 1; // +1 to include the end month
    }

    private function calculateAverageKilometersPerMonth(int $totalMonths): int
    {
        $totalKilometers = $this->endMileage - $this->startMileage;
        return round($totalKilometers / $totalMonths);
    }

    private function generateMileageArray(int $totalMonths, float $averageKilometersPerMonth): array
    {
        $monthlyMileage = [];
        $currentMileage = $this->startMileage;
        $start = new DateTime($this->startDate);

        for ($i = 0; $i < $totalMonths; $i++) {
            $month = (clone $start)->modify("+{$i} months");
            $variation = rand(-$this->tolerance, $this->tolerance);
            $monthlyKilometers = $averageKilometersPerMonth + $variation;

            if ($monthlyKilometers > $this->maxTolerance) {
                $monthlyKilometers = $this->maxTolerance - rand(11, 99);
            }

            if ($i == $totalMonths - 1) {
                $monthlyKilometers = $this->endMileage - $currentMileage;
            }
            if ($monthlyKilometers > $this->maxTolerance) {
                throw new \Exception('Miesięczny przebieg przekracza maksymalną dopuszczalną wartość. Spróbuj ponownie albo zmień parametry wejściowe.');
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