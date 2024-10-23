<?php

declare(strict_types=1);

namespace App\Controller\MileageLog;


use App\Controller\BaseController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class GetAll extends BaseController
{
    public function __invoke(
        Request  $request,
        Response $response
    ): Response
    {
        $pdfDir = BASE_DIR . '/tmp/';
        $pdfFiles = array_diff(scandir($pdfDir), ['.', '..']);
        $pdfList = [];
        foreach ($pdfFiles as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                $pdfList[] = [
                    'name' => $file,
                    'url' => $request->getUri()->getPath() . '/download/' . $file
                ];
            }
        }
        $response->getBody()->write(json_encode($pdfList));
        return $response->withHeader('Content-Type', 'application/json');
    }
}