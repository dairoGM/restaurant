<?php

namespace App\Form\Restaurant;

use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\TipoEvento;
//use App\Entity\Estructura\Provincia;
use App\Entity\Restaurant\Perfil;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PerfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usuario', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('activo', CheckboxType::class, [
                'required' => false
            ])
            ->add('clave', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'invalid_message' => 'Contraseña no coincide.',
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true,
                'first_options' => ['label' => 'Nueva contraseña'],
                'second_options' => ['label' => 'Confirmar contraseña'],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Perfil::class,
        ]);
    }
}
