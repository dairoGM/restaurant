<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Catering;
use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\Reserva;
use App\Entity\Configuracion\TipoCatering;
use App\Entity\Configuracion\TipoEvento;
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

class ReservaType extends AbstractType
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
            ->add('enlace', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Este campo no puede estar vacío.',
                    ])
                ]
            ])
            ->add('activo', CheckboxType::class, [
                'required' => false
            ]) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class,
        ]);
    }
}
