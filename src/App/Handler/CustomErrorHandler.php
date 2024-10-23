<?php

declare(strict_types=1);

namespace App\App\Handler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Throwable;

class CustomErrorHandler extends SlimErrorHandler
{
    protected function respond(): Response
    {
        $exception = $this->exception;
        $statusCode = $exception instanceof HttpInternalServerErrorException ? 500 : $exception->getCode();
        $statusCode = $statusCode >= 400 && $statusCode < 600 ? $statusCode : 500;

        $payload = [
            'status' => 'error',
            'message' => $exception->getMessage(),
        ];

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json');
    }
}