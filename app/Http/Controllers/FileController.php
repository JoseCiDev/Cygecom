<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class FileController extends Controller
{
    public function show(string $path): Response
    {
        $config = Config::get('filesystems.disks.s3');

        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => $config['region'],
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'],
            ],
        ]);

        $result = $s3Client->getObject([
            'Bucket' => $config['bucket'],
            'Key'    => $path,
        ]);

        $fileContent = $result->get('Body');

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $mimeTypes = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
        ];

        $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

        return response($fileContent, 200, [
            'Content-Type' =>  $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}
