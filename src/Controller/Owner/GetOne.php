<?php

declare(strict_types=1);

namespace App\Controller\Owner;


use App\Controller\BaseController;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Symfony\Component\Yaml\Yaml;

final class GetOne extends BaseController
{
    public function __invoke(
        Request $request,
        Response $response
    ): Response {
        $yamlContent = file_get_contents(BASE_DIR . '/src/data/DefaultOwnerData.yaml');
        $data = Yaml::parse($yamlContent);
        return $this->jsonResponse($response, 'success', $data, 200);
    }
}