<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Catering;
use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\TipoCatering;
use App\Entity\Configuracion\TipoEvento;
//use App\Entity\Estructura\Provincia;
//use App\Entity\Personal\Carrera;
//use App\Entity\Personal\NivelEscolar;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CateringType extends AbstractType
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
            ->add('activo', CheckboxType::class, [
                'required' => false
            ])
            ->add('cantidadParticipantes', IntegerType::class, [
                'label' => 'Cantidad de patricipantes',
                'required' => false,
                'attr' => [
                    'min' => 1
                ]
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
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('fecha', TextType::class, [
                'attr' => [
                    'class' => 'date-time-picker'
                ]
            ])
            ->add('tipoCatering', EntityType::class, [
                'class' => TipoCatering::class,
                'label' => 'Tipo de catering',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombre', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Catering::class,
        ]);
    }
}
