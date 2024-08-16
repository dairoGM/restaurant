<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\ComentarioEspacio;
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
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ComentarioEspacioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Este campo no puede estar vacío.',
                    ])
                ]
            ])
            ->add('comentario', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Este campo no puede estar vacío.',
                    ])
                ]
            ])
            ->add('evaluacion', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                ]
            ])
            ->add('imagen', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
            ->add('fecha', TextType::class, [
                'label' => 'Fecha',
                'attr' => [
                    'class' => 'date-time-picker'
                ]
            ])
            ->add('url', UrlType::class, [
                "required" => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ComentarioEspacio::class,
        ]);
    }
}
