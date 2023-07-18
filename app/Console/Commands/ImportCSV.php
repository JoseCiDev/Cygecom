<?php

namespace App\Console\Commands;

use App\Providers\CSVImporter;
use Illuminate\Console\Command;

class ImportCSV extends Command
{
    /**
     * Nome e assinatura do comando com o caminho do arquivo csv de entrada
     * @var string
     */
    protected $signature = 'csv-import {csv-path}';

    /**
     * @var string
     */
    protected $description = 'Lê um arquivo CSV e gera um array de dados. É opcional passar um caminho de arquivo de saída para salvar o retorno do array';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $csvPath = $this->argument('csv-path');
        preg_match('/\/([^\/]+)\.[^.]+$/', $csvPath, $matches);
        $fileName = $matches[1] . time() . rand() . '.php';
        $csvImporter = new CSVImporter($csvPath);
        $outPath = "database/seeders/import/data/$fileName";
        $csvImporter->generateArrayFile($outPath);

        $this->info("Comando executado com sucesso! Verifique o diretório seeders/data o arquivo $fileName");
    }
}
