<?php

namespace App\Form\Restaurant;

use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\Plato;
use App\Entity\Restaurant\Reservacion;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Usuario',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Este campo no puede estar vacío.',
                    ])
                ]
            ])
            ->add('idReservaMesa', TextType::class, [
                'label' => 'ID Reserva Mesa',
                'mapped' => false,
                'required' => false
            ])
            ->add('fechaReservacion', TextType::class, [
                'label' => 'Fecha',
                'mapped' => false,
                'attr' => [
                    'class' => 'date-time-picker'
                ]
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('cantidadPersona', TextType::class, [
                'label' => 'Cantidad de personas',
                'required' => false
            ])
            ->add('cantidad', TextType::class, [
                'label' => 'Cantidad',
                'required' => false
            ])
            ->add('plato', EntityType::class, [
                'class' => Plato::class,
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombre', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('espacio', EntityType::class, [
                'class' => Espacio::class,
                'choice_label' => 'nombreCorto',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombreCorto', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservacion::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

    public function getName()
    {
        return '';
    }
}
