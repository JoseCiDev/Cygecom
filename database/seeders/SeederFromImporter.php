<?php

namespace Database\Seeders;

use App\Providers\ValidatorService;
use Illuminate\Database\Seeder;

abstract class SeederFromImporter extends Seeder
{
    protected array $data;

    public function __construct(protected ValidatorService $validatorService)
    {
    }

    protected function getInputFilePath(): string
    {
        $className = class_basename(static::class);
        $fileName = strtolower(str_replace('Populate', '', $className));
        return __DIR__ . "/$className/data/$fileName.php";
    }

    public function run(): void
    {
        $inputFileName = $this->getInputFilePath();
        $existFileInput = file_exists($inputFileName);
        if (!$existFileInput) {
            throw new \RuntimeException("O arquivo de entrada não existe. Execute o comando para gerar o arquivo antes de rodar o seeder. Verifique o caminho $inputFileName");
        }

        $this->data = require($inputFileName);
        $this->runImporter();
    }

    abstract public function runImporter(): void;
}
