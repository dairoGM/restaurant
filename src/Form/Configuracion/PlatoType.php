<?php

namespace App\Form\Configuracion;


use App\Entity\Configuracion\Plato;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlatoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('activo', CheckboxType::class, [
                'required' => false
            ])
            ->add('sugerenciaChef', CheckboxType::class, [
                'label' => 'Sugerencia del Chef',
                'required' => false
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('nombreLargo', TextareaType::class, [
                'label' => 'Nombre largo',
                'required' => false,
            ])
            ->add('imagen', FileType::class, array(
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false
            ))
            ->add('precio', IntegerType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'min' => 1
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plato::class,
        ]);
    }
}
