<?php

namespace App\Model\Print;

use App\Entity\ReportEntity;
use Dompdf\Dompdf;
use Dompdf\Options;

class HtmlTemplate1
{
    private string $html;

    public function __construct(
        private ReportEntity $report
    )
    {
        $this->html = $this->htmlHeader() . $this->htmlBody() . $this->htmlFooter();
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    private function htmlHeader(): string
    {
        return <<<HTML

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ewidencja Przebiegu Pojazdu</title>
        <style>
        body {
            font-size: 10px; /* Set the default font size */
        }
        h1 {
            font-size: 14px; /* Set the font size for h1 elements */
        }
        p, table {
            font-size: 10px; /* Set the font size for p and table elements */
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            padding-top: 1px; /* Set the top padding for table cells */
            padding-bottom: 1px; /* Set the bottom padding for table cells */
            vertical-align: top; /* Set the vertical alignment for table cells */
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<table border=1 style="width: 100%; background-color: lightgray">
    <tr>
        <td style="text-align: center">
            <span style="font-size: 18px; font-weight: bold">EWIDENCJA PRZEBIEGU POJAZDU</span><br>
            <span style="font-size: 16px">za miesiąc {$this->report->meta->monthName} Rok: {$this->report->meta->year}</span>
        </td>
    </tr>
</table>
<br>
<table  border="0" cellpadding="0" cellspacing="0"  style="width: 100%;  ">
    <tr>
        <td style="width: 50%">
            <table style="width: 100%" cellspacing="4" border="1">
                <tr>
                    <td colspan="2" style="background-color: lightgray">
                        DANE PODATNIKA
                    </td>
                </tr>
                <tr>
                    <td><strong>Firma:</strong></td>
                    <td>{$this->report->company->name}</td>
                </tr>
                <tr>
                    <td><strong>NIP:</strong></td>
                    <td>{$this->report->company->nip}</td>
                </tr>
                <tr>
                    <td><strong>Adres:</strong></td>
                    <td>{$this->report->company->address}</td>
                </tr>
                <tr>
                    <td><strong>Imię i nazwisko osoby<br>prowadzącej pojazd:</strong></td>
                    <td>{$this->report->person->forename} {$this->report->person->surname}</td>
                </tr>
                <tr>
                    <td><strong>Adres:</strong></td>
                    <td>{$this->report->person->address}<br></td>
                </tr>
            </table>
        </td>
        <td style="width: 5px">
        
        </td>
        <td style="width: 50%">
            <table style="width: 100%" cellspacing="4" border="1">
                <tr>
                    <td colspan="2" style="background-color: lightgray">
                        DANE POJAZDU
                    </td>
                </tr>
                <tr>
                    <td><strong>Pojazd:</strong></td>
                    <td>{$this->report->vehicle->brand} {$this->report->vehicle->model}</td>
                </tr>
                <tr>
                    <td><strong>Numer rejestracyjny:</strong></td>
                    <td>{$this->report->vehicle->registration_number}</td>
                </tr>
                <tr>
                    <td><strong>Pojemność silnika:</strong></td>
                    <td>{$this->report->vehicle->engine_capacity}</td>
                </tr>
                <tr>
                    <td><strong>Rok produkcji:</strong></td>
                    <td>{$this->report->vehicle->year}</td>
                </tr>
                <tr>
                    <td><strong>Numer VIN:</strong></td>
                    <td>{$this->report->vehicle->vin}<br><br></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%">
                <tr>
                    <td colspan="2">
                        Daty
                    </td>
                </tr>
                <tr>
                    <td><strong>Rozpoczęcia prowadzonej ewidencji:</strong></td>
                    <td>{$this->report->meta->mileageStartDate}</td>
                </tr>
                <tr>
                    <td><strong>Zakończenia prowadzonej ewidencji:</strong></td>
                    <td>{$this->report->meta->mileageEndDate}</td>
                </tr>
            </table>
        </td>
        <td>    </td>
        <td>
            <table style="width: 100%">
                <tr>
                    <td colspan="2">
                        PRZEBIEG POJAZDU
                    </td>
                </tr>
                <tr>
                    <td><strong>Stan licznika na początku okresu:</strong></td>
                    <td>{$this->report->meta->mileageCounterInitial} km</td>
                </tr>
                <tr>
                    <td><strong>Stan licznika na koniec okresu:</strong></td>
                    <td>{$this->report->meta->mileageCounterFinal} km</td>
                </tr>
                <tr>
                    <td><strong>Przejechana odległość:</strong></td>
                    <td>{$this->report->routeList->mileCounter} km</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
    <table border="1" cellspacing="0" cellpadding="2">
        <thead>
            <tr>
                <th>Lp.</th>
                <th style="width: 70px">Data wyjazdu</th>
                <th>Cel wyjazdu</th>
                <th>Opis trasy (skąd-dokąd)</th>
                <th style="width: 80px">Liczba faktycznie przejechanych kilometrów</th>
                <th>Stawka<br>za 1 km</th>
                <th>Wartość <br>(5 x 6)</th>
                <th>Podpis podatnika</th>
                <th>Uwagi</th>
            </tr>
        </thead>
HTML;
    }

    private function htmlBody(): string
    {
        $html = '<tbody>';
        foreach ($this->report->routeList->routes as $route) {
            $rateCompute = $this->report->meta->rate * $route->distance;
            $html .= <<<HTML
            <tr>
                <td class="center">{$route->nextNumber}</td>
                <td class="center">{$route->date->format('Y-m-d')}</td>
                <td class="center">{$route->destination}</td>
                <td class="center">{$route->description}</td>
                <td class="center">{$route->distance}</td>
                <td class="center">{$this->report->meta->rate}</td>
                <td class="center">{$rateCompute}</td>
                <td></td>
                <td></td>
            </tr>
HTML;
        }
        $html .= '</tbody>';
        return $html;
    }

    private function htmlFooter(): string
    {
        return <<<HTML
        <tfoot>
            <tr>
                <td colspan="4">Podsumowanie strony</td>
                <td colspan="5">{$this->report->routeList->mileCounter} km</td>
            </tr>
            <tr>
                <td colspan="4">Z przeniesienia</td>
                <td colspan="5">0</td>
            </tr>
            <tr>
                <td colspan="4">Razem</td>
                <td colspan="5">{$this->report->routeList->mileCounter} km</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

HTML;
    }

    public function print(string $year, string $month): void
    {
        // Initialize Dompdf with options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->setDefaultFont('DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->html, 'UTF-8');

        // (Optional) Set up the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
//        $dompdf->stream('document.pdf', ['Attachment' => false]);

        // Save the generated PDF to a file on the HDD
        $output = $dompdf->output();
        if(!is_dir(__DIR__ . '/../../../tmp')) {
            mkdir(__DIR__ . '/../../../tmp');
        }
        file_put_contents(__DIR__ . '/../../../tmp/' . $year.$month . '_document . pdf', $output);
    }

}