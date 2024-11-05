<?php

declare(strict_types=1);

namespace Tests\Integration\Vehicle;

use App\Controller\Vehicle\GetOne;
use Tests\Integration\BaseTest;

class GetOneApiTest extends BaseTest
{
    protected $client;


    public function test_api_v1_vehicle()
    {
        $response = $this->client->get('/api/v1/vehicle');
        $this->assertEquals(200, $response->getStatusCode());
        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody, true);
        $this->validateResponseBody($data);
    }

    public function test_invoke()
    {

        // Create the request and response objects
        $request = $this->createRequest('POST', '/api/v1/vehicle');
        $response = $this->createResponse();

        // Create the controller instance with the service mock
        $controller = new GetOne();

        // Invoke the controller
        $response = $controller($request, $response);
        $data = json_decode((string)$response->getBody(), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->validateResponseBody($data);
    }

    private function validateResponseBody($data): void
    {
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('Vehicle', $data['message']);

        $this->assertArrayHasKey('brand', $data['message']['Vehicle']);
        $this->assertArrayHasKey('model', $data['message']['Vehicle']);
        $this->assertArrayHasKey('year', $data['message']['Vehicle']);
        $this->assertArrayHasKey('registration_number', $data['message']['Vehicle']);
        $this->assertArrayHasKey('vin', $data['message']['Vehicle']);
        $this->assertArrayHasKey('engin_capacity', $data['message']['Vehicle']);


        $this->assertNotEmpty($data['message']['Vehicle']['brand']);
        $this->assertNotEmpty($data['message']['Vehicle']['model']);
        $this->assertNotEmpty($data['message']['Vehicle']['year']);
        $this->assertNotEmpty($data['message']['Vehicle']['registration_number']);
        $this->assertNotEmpty($data['message']['Vehicle']['vin']);
        $this->assertNotEmpty($data['message']['Vehicle']['engin_capacity']);

        $this->validateBrand($data['message']['Vehicle']['brand']);
        $this->validateModel($data['message']['Vehicle']['model']);
        $this->validateYear((string)$data['message']['Vehicle']['year']);
        $this->validateRegistrationNumber($data['message']['Vehicle']['registration_number']);
        $this->validateVin($data['message']['Vehicle']['vin']);
        $this->validateEnginCapacity($data['message']['Vehicle']['engin_capacity']);


    }

    private function validateBrand(string $brand): void
    {
        $this->validateStandardString($brand, 'Marka zawiera nieprawidłowe znaki');
    }

    private function validateModel(string $model): void
    {
        $this->validateStandardString($model, 'Model zawiera nieprawidłowe znaki');
    }

    private function validateYear(string $year): void
    {
        $yearPattern = '/^\d{4}$/';
        $this->assertMatchesRegularExpression($yearPattern, $year, 'Rok powinien być 4-cyfrową liczbą');
    }

    private function validateRegistrationNumber(string $registrationNumber): void
    {
        $registrationNumberPattern = '/^[A-Z]{1,3}\s?[0-9]{1,5}\s?[A-Z]{0,2}$/';
        $personalizedPattern = '/^[A-Z0-9\s]{1,8}$/';

        if (!preg_match($registrationNumberPattern, $registrationNumber) && !preg_match($personalizedPattern, $registrationNumber)) {
            throw new \InvalidArgumentException('Numer rejestracyjny zawiera nieprawidłowe znaki');
        }
    }

    private function validateVin(string $vin): void
    {
        $vinPattern = '/^[A-HJ-NPR-Z0-9]{17}$/';
        $this->assertMatchesRegularExpression($vinPattern, $vin, 'VIN zawiera nieprawidłowe znaki');
    }

    private function validateEnginCapacity(string $engin_capacity): void
    {
        $enginCapacityPattern = '/^\d{4}\s?cm3$/';
        $this->assertMatchesRegularExpression($enginCapacityPattern, $engin_capacity, 'Pojemność silnika powinna być 4-cyfrową liczbą, po której następuje "cm3"');
    }


}