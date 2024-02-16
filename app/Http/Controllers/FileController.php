<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;

class FileController extends Controller
{
    /**
     * Display the specified resource.
     * @param string $path
     * @return \Illuminate\Http\Response
     */
    public function show(string $path): \Illuminate\Http\Response
    {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $result = $s3Client->getObject([
            'Bucket' => env('AWS_BUCKET'),
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
