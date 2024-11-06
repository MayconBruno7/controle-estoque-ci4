<?php

/**
 * Valida um CNPJ.
 *
 * @param string $cnpj O CNPJ a ser validado.
 * @return bool Retorna true se o CNPJ for válido, false caso contrário.
 */
function validaCNPJ(string $cnpj): bool
{

    // Remove caracteres não numéricos
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    // Verifica se o CNPJ tem 14 dígitos
    if (strlen($cnpj) != 14) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (ex: 11111111111111)
    if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
        return false;
    }

    // Calcula o primeiro dígito verificador
    $pesos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    $soma1 = 0;
    for ($i = 0; $i < 12; $i++) {
        $soma1 += $cnpj[$i] * $pesos1[$i];
    }
    $digito1 = $soma1 % 11;
    $digito1 = ($digito1 < 2) ? 0 : 11 - $digito1;

    // Verifica o primeiro dígito verificador
    if ($cnpj[12] != $digito1) {
        return false;
    }

    // Calcula o segundo dígito verificador
    $pesos2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    $soma2 = 0;
    for ($i = 0; $i < 13; $i++) {
        $soma2 += $cnpj[$i] * $pesos2[$i];
    }
    $digito2 = $soma2 % 11;
    $digito2 = ($digito2 < 2) ? 0 : 11 - $digito2;

    // Verifica o segundo dígito verificador
    if ($cnpj[13] != $digito2) {
        return false;
    }

    return true;
}
