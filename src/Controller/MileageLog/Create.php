<?php

declare(strict_types=1);

namespace App\Controller\MileageLog;


use App\Controller\BaseController;
use App\Model\MonthlyMilleageGenerator\Generator;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class Create extends BaseController
{
    public function __construct(
        private Generator $generator
    )
    {
        parent::__construct();
    }

    /**
     * @param array<string> $args
     */
    public function __invoke(
        Request  $request,
        Response $response
    ): Response
    {
        $parsedBody = $request->getParsedBody();
        $this->generator->generateMonthlyMileage($parsedBody);
        $response->getBody()->write(json_encode(['status' => 'success']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}