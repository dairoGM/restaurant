<?php

namespace App\DataFixtures;

use App\Entity\Personal\Sexo;

use App\Entity\Planificacion\EstadoPlan;
use App\Entity\Planificacion\Formula;
use App\Entity\Planificacion\TipoPlan;
use App\Entity\Traza\Accion;
use App\Entity\Traza\Objeto;
use App\Entity\Traza\TipoTraza;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {


        $sexos[] = [
            'nombre' => 'Masculino',
            'siglas' => 'M',
        ];
        $sexos[] = [
            'nombre' => 'Femenino',
            'siglas' => 'F',
        ];
        foreach ($sexos as $value) {
            $item = new Sexo();
            $item->setNombre($value['nombre']);
            $item->setSiglas($value['siglas']);
            $manager->persist($item);
        }

        $tbn_accion = ['Crear', 'Modificar', 'Eliminar', 'Inicio de sesión', 'Cierre de sesión'];
        foreach ($tbn_accion as $value) {
            $accion = new Accion();
            $accion->setNombre($value);
            $manager->persist($accion);
        }
        $tbn_objeto = ['Autenticación'];
        foreach ($tbn_objeto as $value) {
            $objeto = new Objeto();
            $objeto->setNombre($value);
            $manager->persist($objeto);
        }
        $tbn_tipo_traza = ['Sesión', 'Negocio'];
        foreach ($tbn_tipo_traza as $value) {
            $tipo_traza = new TipoTraza();
            $tipo_traza->setNombre($value);
            $manager->persist($tipo_traza);
        }

        $manager->flush();
    }

}