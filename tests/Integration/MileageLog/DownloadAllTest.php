<?php

declare(strict_types=1);

namespace Tests\Integration\MileageLog;

use App\Controller\MileageLog\DownloadAll;
use Slim\Psr7\Environment;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Response;
use Tests\Integration\BaseTest;

class DownloadAllTest extends BaseTest
{
    public function test_invoke()
    {
        // Mock the environment
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/mileage-log/download-all'
            ]
        );
        $request = ServerRequestFactory::createFromGlobals($environment);
        $response = new Response();

        // Create the controller instance
        $controller = new DownloadAll();

        // Invoke the controller
        $response = $controller($request, $response);

        // Assert the response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/zip', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('attachment; filename="archive.zip"', $response->getHeaderLine('Content-Disposition'));
        $this->assertNotEmpty((string)$response->getBody());
    }
}