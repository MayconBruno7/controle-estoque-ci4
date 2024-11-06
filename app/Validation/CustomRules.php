<?php

namespace App\Validation;

class CustomRules
{
    public function valida_cpf(string $str, string &$error = null): bool
    {
        return validaCPF($str);
    }

    public function valida_CNPJ(string $str, string &$error = null): bool
    {
        return validaCNPJ($str);
    }
}

