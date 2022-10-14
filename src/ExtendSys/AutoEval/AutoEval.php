<?php

namespace App\ExtendSys\AutoEval;

use function PHPUnit\Framework\throwException;

class AutoEval 
{
    function __construct()
    {        
    }

    public static function aplicarFormula($tipoFormula, $plan, $real) : float
    {
        if($tipoFormula == TipoFormula::$PORCIENTO)
        {
           return AutoEval::aplicarCalculo(new FormulaPorciento(), $plan, $real);
        }
        else if($tipoFormula == TipoFormula::$VALOR)
        {
            return AutoEval::aplicarCalculo(new FormulaValor(), $plan, $real);
        }
                  
        throw new \Exception("El tipo fórmula '$tipoFormula' no existe");
    }


    private static function aplicarCalculo(FormulaInterface $formulaInterface, $plan, $real) : float
    {
        $resultado = $formulaInterface->calcular($plan, $real);
        
        return $resultado;
    }
}