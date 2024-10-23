<?php

declare(strict_types=1);

namespace App\Controller\Vehicle;


use App\Controller\BaseController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Symfony\Component\Yaml\Yaml;

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
        $yamlContent = file_get_contents(BASE_DIR . '/src/data/DefaultVehicleData.yaml');
        $data = Yaml::parse($yamlContent);
        return $this->jsonResponse($response, 'success', $data, 200);
    }
}