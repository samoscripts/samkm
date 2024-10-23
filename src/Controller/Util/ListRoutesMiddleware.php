<?php

namespace App\Controller\Util;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class ListRoutesMiddleware extends BaseController
{
    private App $app;

    public function __construct(App $app)
    {
        parent::__construct();
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $routeCollector = $this->app->getRouteCollector();
        $routes = $routeCollector->getRoutes();

        $routeList = [];
        foreach ($routes as $route) {
            $routeList[] = [
                'methods' => $route->getMethods(),
                'pattern' => $route->getPattern(),
            ];
        }



        $response->getBody()->write(json_encode($routeList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $response->withHeader('Content-Type', 'application/json');

    }
}