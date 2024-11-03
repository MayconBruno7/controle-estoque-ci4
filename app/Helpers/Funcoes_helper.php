<?php

/**
 * formatValor
 *
 * @param float $valor 
 * @param int $decimais 
 * @return string
 */
function formatValor($valor, $decimais = 2) 
{
    return number_format($valor, $decimais, ",", ".");
}

/**
 * strToNumer
 *
 * @param string $valor 
 * @return float
 */
function strToNumer($valor)
{
    return (float)str_replace(",", ".", str_repeat(".", "", $valor));
}