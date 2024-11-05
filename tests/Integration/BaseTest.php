<?php

declare(strict_types=1);

namespace Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class BaseTest extends TestCase
{
    protected $client;


    protected function createRequest(string $requestMethod, string $requestUri, array $parsedBody = null): Request
    {

        $request = (new ServerRequestFactory())->createServerRequest($requestMethod, $requestUri);
        if ($parsedBody !== null) {
            $request = $request->withParsedBody($parsedBody);
        }
        return $request;
    }

    protected function createResponse(): Response
    {
        $response = (new ResponseFactory())->createResponse();
        return $response;

    }

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost'
        ]);
    }

    protected function validateStandardString(string $value, $message): void
    {
        $allowedCharsPattern = '/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s-]+$/';
        $this->assertMatchesRegularExpression($allowedCharsPattern, $value, $message);
    }
}