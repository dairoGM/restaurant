<?php

namespace App\Form\Restaurant;

use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\MetodoPago;
use App\Entity\Configuracion\Plato;
use App\Entity\Restaurant\Pago;
use App\Entity\Restaurant\Reservacion;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreCompleto', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('alias', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('dni', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('celular', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('numeroTransferencia', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('metodoPago', EntityType::class, [
                'class' => MetodoPago::class,
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombre', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pago::class,
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
