<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\Servicio;
use App\Entity\Configuracion\TipoEvento;

//use App\Entity\Estructura\Provincia;
//use App\Entity\Personal\Carrera;
//use App\Entity\Personal\NivelEscolar;
use App\Entity\Configuracion\TipoServicio;
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

class ServicioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('orden', IntegerType::class, [
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

            ))->add('imagenDetallada', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
            ->add('telefonoAuspiciador', TextType::class, [
                'label' => 'Teléfono del auspiciador',
                'required' => false
            ])
            ->add('cantidadParticipantes', IntegerType::class, [
                'label' => 'Cantidad de patricipantes',
                'required' => false,
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('tipoServicio', EntityType::class, [
                'class' => TipoServicio::class,
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombre', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('locacion', TextType::class, [
                'label' => 'Locación',
                'required' => false
            ])
            ->add('gestionarBuffet', CheckboxType::class, [
                'required' => false,
                'label' => 'Gestionar Buffet'
            ])
            ->add('ambientacion', CheckboxType::class, [
                'required' => false,
                'label' => 'Ambientación'
            ])
            ->add('cantidadPlantosPersonas', IntegerType::class, [
                'label' => 'Cantidad de platos por persona',
                'required' => false,
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('cantidadTragosPersonas', IntegerType::class, [
                'label' => 'Cantidad de tragos por persona',
                'required' => false,
                'attr' => [
                    'min' => 1
                ]
            ])






        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Servicio::class,
        ]);
    }
}
