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
     * @param string|null $outputPath Caminho do arquivo de saída.
     * @abstract Responsável por ler o arquivo CSV e retornar o array de dados. Opcional: Gerar o arquivo PHP do caminho de saída com o array de dados.
     */
    public function generateArrayFile(string|null $outputPath = null)
    {
        $file = fopen($this->csvPath, 'r'); // Abre CSV com modo leitura ('r')

        if ($file) {
            $columns = fgetcsv($file); // Lê 1ªlinha/colunas do CSV 
            $data = [];

            while (($row = fgetcsv($file)) !== false) {
                if (count($columns) === count($row)) {
                    $trimmedRow = array_map('trim', $row); // Aplica o trim() em todos os valores da linha
                    $data[] = array_combine($columns, $trimmedRow); // Cria um novo array associativo combinando os cabeçalhos e os valores da linha
                }
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
}
