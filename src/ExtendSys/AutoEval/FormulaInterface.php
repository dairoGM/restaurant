<?php

namespace App\ExtendSys\AutoEval;

use App\Entity\Planificacion\PlanIndicador;
use App\Repository\Planificacion\PlanIndicadorRepository;

interface FormulaInterface 
{
    /**
     * Devuelve el Tipo de Fórmula
     *
     * @return string
     */
    function tipoFormula() : string;

    /**
     * Efectúa un cálculo dado un Plan y un Real
     * Devolviendo un cuantitativo  
     *
     * @param [type] $plan Valor del Plan (valor planificado)
     * @param [type] $real Valor del Real (real efectuado)
     * @return float 
     */
    function calcular($plan, $real) : float;
}