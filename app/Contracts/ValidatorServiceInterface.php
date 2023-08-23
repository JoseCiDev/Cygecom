<?php

namespace App\Contracts;

interface ValidatorServiceInterface
{
    public function registerValidator(array $data);

    public function updateValidator(int $id, array $data);
}
