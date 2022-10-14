<?php

namespace App\DataFixtures;

use App\Entity\Personal\Sexo;

use App\Entity\Planificacion\EstadoPlan;
use App\Entity\Planificacion\Formula;
use App\Entity\Planificacion\TipoPlan;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $estadosPlan = ['Nuevo', 'En revisión', 'Aprobado'];
        foreach ($estadosPlan as $value) {
            $estado = new EstadoPlan();
            $estado->setNombre($value);
            $manager->persist($estado);
        }


        $sexos[] = [
            'nombre' => 'Masculino',
            'siglas' => 'M',
        ];
        $sexos[] = [
            'nombre' => 'Femenino',
            'siglas' => 'F',
        ];
        foreach ($sexos as $value) {
            $sexo = new Sexo();
            $sexo->setNombre($value['nombre']);
            $sexo->setSiglas($value['siglas']);
            $manager->persist($sexo);
        }


        $tiposPlan[] = [
            'nombre' => 'Anual',
            'token_tipo_plan' => 'token-Anual'
        ];
        $tiposPlan[] = [
            'nombre' => 'Mensual',
            'token_tipo_plan' => 'token-Mensual'
        ];
        foreach ($tiposPlan as $value) {
            $tipoPlan = new TipoPlan();
            $tipoPlan->setNombre($value['nombre']);
            $tipoPlan->setTokenTipoPlan($value['token_tipo_plan']);
            $manager->persist($tipoPlan);
        }


        $formulas[] = [
            'nombre' => 'Formula',
            'token_tipo_formula' => 'PORCIENTO'
        ];
        foreach ($formulas as $value) {
            $tipoPlan = new Formula();
            $tipoPlan->setNombre($value['nombre']);
            $tipoPlan->setTokenTipoFormula($value['token_tipo_formula']);
            $manager->persist($tipoPlan);
        }

        $manager->flush();
    }

}