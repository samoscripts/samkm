<?php

declare(strict_types=1);

namespace App\Controller\MileageLog;


use App\Controller\BaseController;
use App\Model\MonthlyMilleageGenerator\EventParametersApi;
use App\Model\MonthlyMilleageGenerator\Generator;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class Create extends BaseController
{
    /**
     * @param array<string> $args
     */
    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): Response {

        $parsedBody = $request->getParsedBody();
        $generator = new Generator(
            new EventParametersApi($parsedBody)
        );
        $generator->generateMonthlyMileage();
        $response->getBody()->write(json_encode(['status' => 'success']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}