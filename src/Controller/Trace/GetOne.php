<?php

declare(strict_types=1);

namespace App\Controller\Trace;


use App\Controller\BaseController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class GetOne extends BaseController
{
    /**
     * @param array<string> $args
     */
    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): Response {
        $data = ['toMock'];
        return $this->jsonResponse($response, 'success', $data, 200);
    }
}