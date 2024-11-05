<?php

declare(strict_types=1);

// Route to handle empty URL
use App\Controller\FormController;
use App\Controller\MileageLog;
use App\Controller\Owner;
use App\Controller\Trace;
use App\Controller\Util\ListRoutesMiddleware;
use App\Controller\Vehicle;
use App\Model\MonthlyMilleageGenerator\EventParametersApi;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use App\Model\MonthlyMilleageGenerator\Generator;


return static function (App $app) {

    // Define a simple route
    $app->get('/list-routes', new ListRoutesMiddleware($app));
    $app->get('/form', [FormController::class, 'showForm']);
    $app->get('/', [FormController::class, 'showForm']);

    $app->group('/api/v1', function (RouteCollectorProxy $app): void {
        $app->group('/mileagelog', function (RouteCollectorProxy $app): void {
            $app->get('', MileageLog\GetAll::class);
            $app->get('/download', MileageLog\DownloadAll::class);
            $app->get('/download/{fileName}', MileageLog\DownloadOne::class);
            $app->post('', new MileageLog\Create(new Generator(new EventParametersApi())));
        });
        $app->group('/trace', function (RouteCollectorProxy $app): void {
            $app->get('', Trace\GetAll::class);
            $app->get('{id}', Trace\GetOne::class);
            $app->delete('{id}', Trace\Delete::class);
            $app->put('{id}', Trace\Update::class);
            $app->post('', Trace\Create::class);
        });
        $app->group('/owner', function (RouteCollectorProxy $app): void {
            $app->get('', Owner\GetOne::class);
        });
        $app->group('/vehicle', function (RouteCollectorProxy $app): void {
            $app->get('', Vehicle\GetOne::class);
        });
    });

    // Wildcard route to capture any unmatched addresses
    $app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', function (Request $request, Response $response, $args) {
        $response->getBody()->write("This route doesn't match any predefined patterns.");
        return $response->withStatus(404);
    });

    $app->get('*', [FormController::class, 'showForm']);

    return $app;
};

