<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\Servicio;
use App\Entity\Configuracion\TipoEvento;

//use App\Entity\Estructura\Provincia;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EspacioGaleriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imagen1', FileType::class, array(
                "attr" => array("type" => "file"),
                'label' => 'Imagen 1',
//                "required" => false,
                "mapped" => false,

            ))->add('imagen2', FileType::class, array(
                "attr" => array("type" => "file"),
                'label' => 'Imagen 2',
//                "required" => false,
                "mapped" => false,

            ))->add('imagen3', FileType::class, array(
                "attr" => array("type" => "file"),
                'label' => 'Imagen 3',
//                "required" => false,
                "mapped" => false,

            ))->add('imagen4', FileType::class, array(
                "attr" => array("type" => "file"),
                'label' => 'Imagen 4',
//                "required" => false,
                "mapped" => false,

            ))->add('imagen5', FileType::class, array(
                "attr" => array("type" => "file"),
                'label' => 'Imagen 5',
//                "required" => false,
                "mapped" => false,

            ))->add('imagen6', FileType::class, array(
                "attr" => array("type" => "file"),
                'label' => 'Imagen 6',
//                "required" => false,
                "mapped" => false,

            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Espacio::class,
        ]);
    }
}
