<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\Portada;
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

class PortadaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('activo', CheckboxType::class, [
                'required' => false
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('imagen', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
            ->add('imagen2', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
            ->add('imagen3', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
            ->add('imagen4', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))  ->add('imagenFooter', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Portada::class,
        ]);
    }
}
