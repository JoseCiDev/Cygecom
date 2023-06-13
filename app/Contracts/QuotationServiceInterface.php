<?php

namespace App\Contracts;

interface QuotationServiceInterface
{
    public function getQuotations();

    public function registerQuotation(array $data);
}
