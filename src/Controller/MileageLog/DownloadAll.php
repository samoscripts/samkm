<?php

declare(strict_types=1);

namespace App\Controller\MileageLog;

use App\Controller\BaseController;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use ZipArchive;

final class DownloadAll extends BaseController
{
    public function __invoke(
        Request  $request,
        Response $response
    ): Response
    {
        $zipFileName = BASE_DIR . '/tmp/' . uniqid() . '.zip';
        $this->createZipArchive(BASE_DIR . '/tmp/', $zipFileName);

        $content = file_get_contents($zipFileName);
        $response->getBody()->write($content);
        unlink($zipFileName);
        return $response
            ->withHeader('Content-Type', 'application/zip')
            ->withHeader('Content-Disposition', 'attachment; filename="archive.zip"');
    }

    private function createZipArchive(string $sourceDir, string $zipFileName): void
    {
        $zip = new ZipArchive();
        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($sourceDir),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $filename = basename($filePath);
                    $zip->addFile($filePath, $filename);
                }
            }
            $zip->close();
        } else {
            throw new \RuntimeException('Could not create zip archive');
        }
    }
}