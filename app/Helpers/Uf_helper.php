<?php

/**
 * descricaoRegiao
 *
 * @param mixed $regiao 
 * @return string
 */
function descricaoRegiao($regiao)
{
    $aRegiao = [
        "...",
        "Norte",
        "Nordeste",
        "Sudeste",
        "Centro Oeste",
        "Sul"
    ];

    if ($regiao == "") {
        return "...";
    } else  {
        return $aRegiao[$regiao];
    }
}

/**
 * comboboxRegiao
 *
 * @param integer $regiao 
 * @return string
 */
function comboboxRegiao($regiao)
{
    return '
    <label for="regiao" class="form-label">Região</label>
    <select name="regiao" id="regiao" class="form-control" required>
        <option value=""  ' . (isset($regiao) ? ($regiao == ''  ? "selected" : "") : "" ) . '>.....</option>
        <option value="1" ' . (isset($regiao) ? ($regiao == '1' ? "selected" : "") : "" ) . '>Norte</option>
        <option value="2" ' . (isset($regiao) ? ($regiao == '2' ? "selected" : "") : "" ) . '>Nordeste</option>
        <option value="3" ' . (isset($regiao) ? ($regiao == '3' ? "selected" : "") : "" ) . '>Sudeste</option>
        <option value="4" ' . (isset($regiao) ? ($regiao == '4' ? "selected" : "") : "" ) . '>Centro Oeste</option>
        <option value="5" ' . (isset($regiao) ? ($regiao == '5' ? "selected" : "") : "" ) . '>Sul</option>
    </select>';
}