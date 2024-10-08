<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\ExperienciaCulinaria;
use App\Entity\Configuracion\TipoEvento;
use App\Entity\Configuracion\TipoExperienciaCulinaria;
//use App\Entity\Estructura\Provincia;

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

class ExperienciaCulinariaType extends AbstractType
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
            ->add('fecha', TextType::class, [
                'attr' => [
                    'class' => 'date-time-picker'
                ]
            ])
            ->add('tipoExperienciaCulinaria', EntityType::class, [
                'label' => 'Tipo de experiencia',
                'class' => TipoExperienciaCulinaria::class,
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
            'data_class' => ExperienciaCulinaria::class,
        ]);
    }
}
