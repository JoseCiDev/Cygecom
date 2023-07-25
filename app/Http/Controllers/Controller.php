<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\UploadedFile;


class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected static function sendFilesToS3(UploadedFile | array $file, string $type_module, string | int $id_folder)
    {
        $out = [
            'success' => false,
            'exception' => null,
            'urls_bucket' => []
        ];
        try {
            $getBasePath = function () {
                $systemBasePath = "test_local/gcom";
                $enviroviment = env('APP_ENV');
                if ($enviroviment !== 'local') {
                    $systemBasePath = $enviroviment === 'production' ? 'production/gcom' : 'test_homolog/gcom';
                }
                return $systemBasePath;
            };
            if ($file instanceof UploadedFile) {
                $systemBasePath = $getBasePath() . '/' . $type_module . '/' . $id_folder;
                $pathFromS3 = $file->store($systemBasePath, 's3');
                $out['success'] = is_string($pathFromS3);
                $out['urls_bucket'][] = $pathFromS3;
            }
            if (is_array($file)) {
                $fails = 0;
                foreach ($file as $eachFile) {
                    if ($eachFile instanceof UploadedFile) {
                        $systemBasePath = $getBasePath() . '/' . $type_module . '/' . $id_folder;
                        $pathFromS3 = $eachFile->store($systemBasePath, 's3');
                        $out['urls_bucket'][] = $pathFromS3;
                        if (!is_string($pathFromS3)) {
                            $fails++;
                        }
                    } else {
                        throw new \Exception("Formato inválido, utilize \$request->file('arquivo_teste') que retorna um UploadedFile ou um array de UploadedFile.");
                    }
                }
                $out['success'] = true;
                if ($fails) {
                    $out['success'] = false;
                    throw new \Exception("Não foi possível enviar $fails arquivo(s) para o S3");
                }
            }
        } catch (\Exception $e) {
            $out['exception'] = $e->getMessage();
        }
        return (object) $out;
    }
}
