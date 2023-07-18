<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;

class CSVImporter extends ServiceProvider
{
    /**
     * @abstract Exemplo de utilização:
     * $csvPath = base_path('database/seeders/import/csv/cadastro-fornecedores-callisto.csv');
     * $outputPath = base_path('database/seeders/import/data/suppliers-hkm.php');
     * $csvImporter = new CSVImporter($csvPath);
     * $csvImporter->generateArrayFile($outputPath);
     */
    public function __construct(private string $csvPath)
    {
    }

    /**
     * @param string|null $outputPath Caminho do arquivo de saída.
     * @abstract Responsável por ler o arquivo CSV e retornar o array de dados. Opcional: Gerar o arquivo PHP do caminho de saída com o array de dados.
     */
    public function generateArrayFile(?string $outputPath = null): array
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

        if ($outputPath) {
            $exportData = var_export($data, true);
            $output = "<?php\n\nreturn " . $exportData . ";\n";
            file_put_contents($outputPath, $output);
        }

        return $data;
    }
}
