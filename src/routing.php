<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FormController;
use App\Controllers\PdfController;
use App\Model\MonthlyMilleageGenerator\EventParametersApi;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$app = AppFactory::create();
$app->addBodyParsingMiddleware(); // Dodaj middleware do parsowania ciała żądania
$loader = new FilesystemLoader('Views');
$twig = new Environment($loader);

// Route to handle empty URL
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Welcome to the homepage!");
    return $response;
});
// Define a simple route
$app->get('/form', [FormController::class, 'showForm']);
$app->get('/api/default-data', [FormController::class, 'getDefaultData']);
$app->get('/api/pdf-list', [PdfController::class, 'showPdfList']);
$app->get('/getFile/{fileName}', function (Request $request, Response $response, $args) {
    $fileName = $args['fileName'];
    $content = file_get_contents(__DIR__ . '/../tmp/' . $fileName);

    $response->getBody()->write($content);
    return $response->withHeader('Content-Type', 'application/pdf')
        ->withHeader('Content-Disposition', 'inline; filename="' . $fileName . '"');
});


$app->get('/api/mileage', function (Request $request, Response $response, $args) {
    // Your logic to fetch mileage data
    $data = ['mileage' => 1500];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});
$app->post('/api/mileage', function (Request $request, Response $response, $args) {
    try{
        $parsedBody = $request->getParsedBody();
        // Your logic to handle POST data
        $generator = new \App\Model\MonthlyMilleageGenerator\Generator(
            new EventParametersApi($parsedBody)
        );
        $generator->generateMonthlyMileage();
        $response->getBody()->write(json_encode(['status' => 'success']));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        $response->getBody()->write(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
        return $response->withHeader('Content-Type', 'application/json');
    }
});
// Wildcard route to capture any unmatched addresses
$app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', function (Request $request, Response $response, $args) {
    $response->getBody()->write("This route doesn't match any predefined patterns.");
    return $response->withStatus(404);
});

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
            throw new Exception("Notice: [$errno] $errstr - $errfile:$errline");
        // Handle other error types here
        default:
            throw new Exception("Error: [$errno] $errstr - $errfile:$errline");
    }

    /* Don't execute PHP internal error handler */
    return true;
}

set_error_handler("customErrorHandler");

$app->get('*', [FormController::class, 'showForm']);

$app->run();