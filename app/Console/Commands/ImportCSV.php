<?php

namespace App\Console\Commands;

use App\Providers\CSVImporter;
use App\Providers\ValidatorService;
use Illuminate\Console\Command;
use ReflectionClass;

class ImportCSV extends Command
{
    public function __construct(private ValidatorService $validatorService)
    {
        parent::__construct();
    }
    /**
     * Nome e assinatura do comando com o type de importação.
     * @var string
     */
    protected $signature = 'csv-import {type}';

    /**
     * @var string
     */
    protected $description = 'Lê um arquivo CSV e gera php retornando um array de dados filtrados de acordo com o parâmetro type. 
    A partir do parâmetro $type, é buscado o nome da classe que possui referência com o $type. Essa classe deve ter um método filter().';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $type = $this->argument('type');

        $outputs = [
            'suppliers' => \Database\Seeders\PopulateSuppliers\Filter::class,
        ];

        $fullQualifiedName = $outputs[$type];
        $reflectionClass = new ReflectionClass($fullQualifiedName);
        $filePath = $reflectionClass->getFileName();
        $csvPath = dirname($filePath) . "/csv/$type.csv";

        $csvImporter = new CSVImporter($csvPath);
        $dataImported = $csvImporter->generateArrayFile();

        $filterSupplierArray = new $outputs[$type]($this->validatorService);
        $response = $filterSupplierArray->filter($dataImported);

        $exportData = $this->varexport($response);
        $output = "<?php\n\nreturn " . str_replace(["\n", "  "], "", $exportData) . ";";
        $outputPath = dirname($filePath) . "/data/$type.php";
        file_put_contents($outputPath, $output);

        $this->info("Comando executado com sucesso! Verifique o diretório seeders/data o arquivo $outputPath");
    }

    function varexport($expression)
    {
        $export = var_export($expression, true);
        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        return $export;
    }
}
