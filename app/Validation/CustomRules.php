<?php

namespace App\Validation;

class CustomRules
{
    /**
     * valida_cpf function
     *
     * @param string $str
     * @param string|null $error
     * @return boolean
     */
    public function valida_cpf(string $str, string &$error = null): bool
    {
        return validaCPF($str);
    }

    /**
     * valida_CNPJ function
     *
     * @param string $str
     * @param string|null $error
     * @return boolean
     */
    public function valida_CNPJ(string $str, string &$error = null): bool
    {
        return validaCNPJ($str);
    }
}

