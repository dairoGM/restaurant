<?php

namespace App\ExtendSys\AutoEval;

class FormulaValor implements FormulaInterface 
{
    /**
     * Devuelve el Tipo de Fórmula
     *
     * @return string
     */
    function tipoFormula() : string
    {
        return TipoFormula::$VALOR;
    }

    /**
     * Efectúa un cálculo dado un Plan y un Real
     * Devolviendo un cuantitativo  
     *
     * @param [type] $plan Valor del Plan (valor planificado)
     * @param [type] $real Valor del Real (real efectuado)
     * @return float 
     */
    function calcular($plan, $real) : float
    {
        if(!isset($plan) || $plan == 0)
        {
            return 0;
        }

        if(!isset($real) || $real == 0)
        {
            return 0;
        }

        return $real;
    }
}