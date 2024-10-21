<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FormController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$app = AppFactory::create();
$loader = new FilesystemLoader('Views');
$twig = new Environment($loader);

// Define a simple route
$app->get('/form', [FormController::class, 'showForm']);
$app->get('/api/default-data', [FormController::class, 'getDefaultData']);


$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->get('/api/mileage', function (Request $request, Response $response, $args) {
    // Your logic to fetch mileage data
    $data = ['mileage' => 1500];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/mileage', function (Request $request, Response $response, $args) {
    $parsedBody = $request->getParsedBody();
    // Your logic to handle POST data
    $response->getBody()->write(json_encode(['status' => 'success']));
    return $response->withHeader('Content-Type', 'application/json');
});
$app->run();