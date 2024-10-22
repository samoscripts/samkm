<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;

class PdfController extends BaseController
{

    public function showPdfList(Request $request, Response $response, $args): Response
    {
        $pdfDir = __DIR__ . '/../../tmp/';
        $pdfFiles = array_diff(scandir($pdfDir), ['.', '..']);
        $pdfList = [];
        foreach ($pdfFiles as $file) {
            $pinfo = pathinfo($file, PATHINFO_EXTENSION);
            if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                $pdfList[] = [
                    'name' => $file,
                    'url' => '/getFile/' . $file
                ];
            }
        }

        $response->getBody()->write(json_encode($pdfList));
        return $response->withHeader('Content-Type', 'application/json');
//
//        $html = $this->twig->render('pdfList.twig', ['pdf_files' => $pdfList]);
//        $response->getBody()->write($html);
//        $response = $response->withHeader('Content-Type', 'text/html');
//        return $response;
    }
}