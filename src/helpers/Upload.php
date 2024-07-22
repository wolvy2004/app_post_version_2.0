<?php

declare(strict_types=1);

namespace App\helpers;

use Nyholm\Psr7\ServerRequest as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\UploadedFile;

class Upload
{
    static public function save(Request $request, string $directory): string
    {
        $directory = $directory . DIRECTORY_SEPARATOR;
        $uploadedFiles = $request->getUploadedFiles();
        $file = $uploadedFiles['file'];
        $filename = $request->getParsedBody()['username'] . rand(0, 20000);
        if ($file->getError() === UPLOAD_ERR_OK) {

            $filename = Self::moveUploadedFile($directory, $file, $filename);
        }
        return $filename;
    }

    static private function moveUploadedFile($directory, UploadedFileInterface  $uploadedFile, $filename): string
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $filename = sprintf('%s.%0.8s', $filename, $extension);

        if (file_exists($directory . DIRECTORY_SEPARATOR . $filename)) {
            unlink($directory . DIRECTORY_SEPARATOR . $filename);
        }

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
