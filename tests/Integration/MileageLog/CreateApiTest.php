<?php

declare(strict_types=1);

namespace Tests\Integration\MileageLog;

use App\Controller\MileageLog\Create;
use App\Model\MonthlyMilleageGenerator\EventParametersApi;
use App\Model\MonthlyMilleageGenerator\Generator;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Environment;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Tests\Integration\BaseTest;

class CreateApiTest extends BaseTest
{

    public function test_invoke()
    {
        // Mock the dependencies
        $parsedBody = $this->getMockParsedBody();
        $eventParametersApiMock = $this->createMock(EventParametersApi::class);
        $generatorMock = $this->getMockBuilder(Generator::class)
            ->setConstructorArgs([$eventParametersApiMock])
            ->getMock();
        $generatorMock->expects($this->once())
            ->method('generateMonthlyMileage');

        // Create the request and response objects
        $request = $this->createRequest('GET', '/mileage-log/create', $parsedBody);
        $response = $this->createResponse();

        // Create the controller instance with the service mock
        $controller = new Create($generatorMock);

        // Invoke the controller
        $response = $controller($request, $response);

        // Assert the response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertJsonStringEqualsJsonString(
            json_encode(['status' => 'success']),
            (string)$response->getBody()
        );
    }

    private function getMockParsedBody()
    {
        $parsedBody = <<<EOL
            {
              "company_name": "MIXMAX Józef Dzienisz",
              "nip": "588-000-00-00",
              "address": "Ul. Łąkowa 32, 84-240 Reda",
              "forename": "Józef",
              "surname": "Dzienisz",
              "vehicle_brand": "BMW",
              "vehicle_model": "X5",
              "vehicle_year": "2016",
              "registration_number": "GWE 12345",
              "vin": "WBAWZ51030LM12345",
              "engine_capacity": "3.0",
              "date_start": "2024-03",
              "date_end": "2024-06",
              "mileage_start": "1000",
              "mileage_end": "3000",
              "tolerance_max": "1000",
              "tolerance": "300"
            }
        EOL;

        return json_decode($parsedBody, true);
    }
}