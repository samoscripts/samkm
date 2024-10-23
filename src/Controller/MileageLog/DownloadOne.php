<?php

declare(strict_types=1);

namespace App\Controller\MileageLog;


use App\Controller\BaseController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

final class DownloadOne extends BaseController
{
    /**
     * @param array<string> $args
     */
    public function __invoke(
        Request  $request,
        Response $response,
        array    $args
    ): Response
    {
        $fileName = $args['fileName'];
        $content = file_get_contents(BASE_DIR . '/tmp/' . $fileName);
        $response->getBody()->write($content);
//        return $response
//            ->withHeader('Content-Type', 'application/pdf')
//            ->withHeader('Content-Disposition', 'attachment; filename="'. $fileName. '"');
        return $response
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'inline; filename="' . $fileName . '"');
    }
}