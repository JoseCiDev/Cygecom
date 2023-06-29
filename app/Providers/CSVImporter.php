<?php

namespace App\Providers;

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
    protected string $csvPath;

    public function __construct(string $csvPath)
    {
        $this->csvPath = $csvPath;
    }

    /**
     * @param string $outputPath Caminho do arquivo de saída.
     * @abstract Responsável por ler o arquivo CSV e gerar o arquivo PHP com o array de dados.
     */
    public function generateArrayFile(string $outputPath): void
    {
        $file = fopen($this->csvPath, 'r'); // Abre CSV com modo leitura ('r')

        if ($file) {
            $columns = fgetcsv($file); // Lê 1ªlinha/colunas do CSV 
            $data = [];

            while (($row = fgetcsv($file)) !== false) {
                if (count($columns) === count($row)) {
                    $data[] = array_combine($columns, $row); // Cria um novo array associativo combinando os cabeçalhos e os valores da linha
                }
            }

            fclose($file);

            $exportData = var_export($data, true);
            $output = "<?php\n\nreturn " . $exportData . ";\n";

            file_put_contents($outputPath, $output);
        }
    }
}
