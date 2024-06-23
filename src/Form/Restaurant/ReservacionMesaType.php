<?php

namespace App\Form\Restaurant;

use App\Entity\Configuracion\Espacio;
use App\Entity\Restaurant\ReservacionMesa;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservacionMesaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Usuario',
                'mapped' => false,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('nombreCompleto', TextType::class, [
                'label' => 'Nombre completo',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('celular', TextType::class, [
                'label' => 'Celular',
                'constraints' => [
                    new NotBlank()
                ]
            ])
//            ->add('dni', TextType::class, [
//                'label' => 'DNI',
//                'constraints' => [
//                    new NotBlank()
//                ]
//            ])
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
            ->add('cantidadMesa', TextType::class, [
                'label' => 'Cantidad de mesas',
                'constraints' => [
                    new NotBlank()
                ]
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
            'data_class' => ReservacionMesa::class,
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
