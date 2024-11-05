<?php

declare(strict_types=1);

namespace Tests\Integration\Owner;

use App\Controller\Owner\GetOne;
use Tests\Integration\BaseTest;

class GetOneApiTest extends BaseTest
{
    protected $client;


    public function test_api_v1_owner()
    {
        $response = $this->client->get('/api/v1/owner');
        $this->assertEquals(200, $response->getStatusCode());
        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody, true);
        $this->validateResponseBody($data);
    }


    public function test_invoke()
    {
        // Create the request and response objects
        $request = $this->createRequest('POST', '/api/v1/owner');
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

    private function validateResponseBody($data)
    {
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('Company', $data['message']);
        $this->assertArrayHasKey('Person', $data['message']);

        $this->assertArrayHasKey('name', $data['message']['Company']);
        $this->assertArrayHasKey('nip', $data['message']['Company']);
        $this->assertArrayHasKey('address', $data['message']['Company']);

        $this->assertNotEmpty($data['message']['Company']['name']);
        $this->assertNotEmpty($data['message']['Company']['nip']);
        $this->assertNotEmpty($data['message']['Company']['address']);

        $this->assertArrayHasKey('forename', $data['message']['Person']);
        $this->assertArrayHasKey('surname', $data['message']['Person']);
        $this->assertNotEmpty($data['message']['Person']['forename']);
        $this->assertNotEmpty($data['message']['Person']['surname']);

        $this->validateCompanyName($data['message']['Company']['name']);
        $this->validateNip($data['message']['Company']['nip']);
        $this->validateForename($data['message']['Person']['forename']);
        $this->validateSurname($data['message']['Person']['surname']);
        $this->validateAddress($data['message']['Company']['address']);
    }
    private function validateForename(string $forename): void
    {
        $this->validateStandardString($forename, 'Forename contains invalid characters');
    }

    private function validateSurname(string $surname): void
    {
        $this->validateStandardString($surname, 'Surname contains invalid characters');
    }

    private function validateCompanyName(string $name): void
    {
        $allowedCharsPattern = '/^[a-zA-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s,.\-&\'()\/\\\+]+$/';
        $this->assertMatchesRegularExpression($allowedCharsPattern, $name, 'Company name contains invalid characters');
    }

    private function validateAddress(string $address): void
    {
        $allowedCharsPattern = '/^[a-zA-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s,.\-\/#]+$/';
        $this->assertMatchesRegularExpression($allowedCharsPattern, $address, 'Address contains invalid characters');
    }

    private function validateNip(string $nip): void
    {
        // Define your NIP validation logic here
        $nipPattern = '/^\d{10}$|^\d{3}-\d{3}-\d{2}-\d{2}$/';
        $this->assertMatchesRegularExpression($nipPattern, $nip, 'NIP should be a 10-digit number or in the format XXX-XXX-XX-XX');
    }
}