<?php

namespace App\Console\Commands;

use App\Providers\ValidatorService;
use Illuminate\Console\Command;

class FilterSupplierArray extends Command
{
    public function __construct(private ValidatorService $validatorService)
    {
        parent::__construct();
    }

    /**
     * Nome e assinatura do comando com o caminho do arquivo php de entrada
     * @var string
     */
    protected $signature = 'filter-array-supplier {php-file-path}';

    /**
     * @var string
     */
    protected $description = 'Importa um arquivo php que retorna um array de fornecedores e cria um novo arquivo php que retorna um novo array filtrado.';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $phpFilePath = $this->argument('php-file-path');
        $suppliers = require $phpFilePath;

        $filteredSuppliers = [];
        $existingCorporateNames = [];

        if (!is_array($suppliers) && empty($suppliers)) {
            return $this->error('O array de fornecedores está vazio ou não foi encontrado no arquivo importado.');
        }

        foreach ($suppliers as $supplier) {
            $isValidCnpj = $this->validateCnpj($supplier['cpf_cnpj']);
            $validator = $this->validatorService->supplier($supplier);
            $isDuplicate = in_array($supplier['corporate_name'], $existingCorporateNames);
            if (!$isValidCnpj || $isDuplicate || $validator->fails()) {
                continue;
            }

            $supplier['qualification'] = 'qualificado';
            $filteredSuppliers[] = $supplier;

            $existingCorporateNames[] = $supplier['corporate_name'];
        }

        preg_match('/\/([^\/]+)\.[^.]+$/', $phpFilePath, $matches);
        $fileName = 'filtered-' . $matches[1] . time() . rand() . '.php';
        $outputFilePath = "database/seeders/import/data/$fileName";

        $outputContent = "<?php\n\nreturn " . var_export($filteredSuppliers, true) . ";\n";
        file_put_contents($outputFilePath, $outputContent);

        $this->info("Novo arquivo PHP criado com sucesso! Verifique em $outputFilePath");
    }

    private function validateCnpj(string $cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $sum = 0;
        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights1[$i];
        }

        $digit1 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        $sum = 0;
        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights2[$i];
        }

        $digit2 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        return $cnpj[12] == $digit1 && $cnpj[13] == $digit2;
    }
}
