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
use Symfony\Component\Validator\Constraints\File;

class EspacioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoria', TextType::class, [
                'label' => 'Categoría',
                'required' => false,
            ])
            ->add('nombreCorto', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Este campo no puede estar vacío.',
                    ])
                ]
            ])
            ->add('nombreLargo', TextareaType::class, [
                'required' => false,
            ])
            ->add('activo', CheckboxType::class, [
                'required' => false
            ])
            ->add('reservar', CheckboxType::class, [
                'required' => false
            ])
            ->add('orden', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('cantidadMesa', IntegerType::class, [
                'label' => 'Cantidad de mesas',
                'required' => false,
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('imagenPortada', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))->add('imagenBanner', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
            ->add('codigoReel', TextareaType::class, array(
                'label' => 'Código del reel',
                "required" => false

            ))
            ->add('imagenDetallada', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))->add('imagenMenu', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))->add('video', FileType::class, [
                'label' => 'Video', // Etiqueta para el campo
                'mapped' => false, // Importante: el archivo no está mapeado directamente a la entidad
                'required' => false, // Configura si el campo es obligatorio
                'constraints' => [
                    new File([
                        'maxSize' => '1024M', // Tamaño máximo permitido, ajustable según tus necesidades
                        'mimeTypes' => [
                            'video/mp4', // Restricción para que solo se suban videos en formato MP4
                            'video/avi',
                            'video/mpeg',
                            'video/quicktime',
                        ],
                        'mimeTypesMessage' => 'Suba un video de extención válida (MP4, AVI, MPEG, MOV)',
                    ])
                ],
                'attr' => [
                    'class' => 'form-control', // Clase CSS para estilizar el campo
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Espacio::class,
        ]);
    }
}
