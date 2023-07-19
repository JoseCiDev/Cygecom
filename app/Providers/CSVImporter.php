<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;

class CSVImporter extends ServiceProvider
{
    /**
     * @abstract Exemplo de utilização:
     * $csvPath = base_path('database/seeders/import/csv/cadastro-fornecedores-callisto.csv');
     * $csvImporter = new CSVImporter($csvPath);
     * $csvImporter->generateArrayFile();
     */
    public function __construct(private string $csvPath)
    {
    }

    /**
     * @abstract Responsável por ler o arquivo CSV e retornar o array de dados.
     */
    public function generateArrayFile(): array
    {
        $file = fopen($this->csvPath, 'r');
        if (!$file) {
            throw new Exception('Falha ao abrir o arquivo CSV.');
        }

        $columns = fgetcsv($file);
        $data = [];

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) !== count($columns)) {
                continue;
            }

            $trimmedRow = array_map('trim', $row);
            $combinedData = array_combine($columns, $trimmedRow);

            $data[] = $combinedData;
        }

        fclose($file);

        return $data;
    }
}
