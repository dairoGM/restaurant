<?php

namespace App\Form\Catalogo;

use App\Entity\Catalogo\Compania;
use App\Entity\Catalogo\Grupo;
use App\Entity\Catalogo\Cedis;
use App\Entity\Catalogo\Territorio;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CedisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('clave', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'allowEmptyString' => true,
                        'maxMessage' => 'El número máximo de caracteres permitidos es 10',
                        'max' => 10,
                    ]),
                ]
            ])
            ->add('cedis', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'allowEmptyString' => true,
                        'maxMessage' => 'El número máximo de caracteres permitidos es 50',
                        'max' => 50,
                    ]),
                ]
            ])
            ->add('cedisNuevo', TextType::class, [
                'label' => 'Cedis nuevo',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'allowEmptyString' => true,
                        'maxMessage' => 'El número máximo de caracteres permitidos es 50',
                        'max' => 50,
                    ]),
                ]
            ])
            ->add('activo', CheckboxType::class, [
                'required' => false,
                'label' => 'Habilitado'
            ])
            ->add('territorio', EntityType::class, [
                'class' => Territorio::class,
                'choice_label' => 'territorio',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.territorio', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('grupo', EntityType::class, [
                'class' => Grupo::class,
                'choice_label' => 'grupo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.grupo', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])->add('compania', EntityType::class, [
                'class' => Compania::class,
                'choice_label' => 'nombre',
                'label' => 'Compañía',
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
            'data_class' => Cedis::class,
        ]);
    }
}
