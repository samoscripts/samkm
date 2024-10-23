<?php

namespace App\Controller;

use Slim\Psr7\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);
    }

    protected function jsonResponse(Response $response, string $status, $message, int $code): Response
    {
        $result = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }
}