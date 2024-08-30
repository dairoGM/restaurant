<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\MetodoPago;
use App\Entity\Configuracion\PoliticaReservacion;
use App\Entity\Configuracion\TipoEvento;

//use App\Entity\Estructura\Provincia;
use App\Entity\Configuracion\TipoMoneda;
use App\Entity\Configuracion\TipoReservacion;
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

class PoliticaReservacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('imagen', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PoliticaReservacion::class
        ]);
    }
}
