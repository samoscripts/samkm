<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class FormController extends BaseController
{

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function showForm(Request $request, Response $response, $args): \Psr\Http\Message\MessageInterface|Response
    {
        $html = $this->twig->render('form.twig');
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }

    public function getDefaultData(Request $request, Response $response, $args): \Psr\Http\Message\MessageInterface|Response
    {
        $yamlContent = file_get_contents(__DIR__ . '/../data/HeaderDataToPrint.yaml');
        $data = Yaml::parse($yamlContent);
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}