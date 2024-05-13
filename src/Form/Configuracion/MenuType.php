<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\Menu;
use App\Entity\Configuracion\Plato;
use App\Entity\Configuracion\TipoEvento;
use App\Entity\Configuracion\TipoExperienciaGastronomica;
use App\Entity\Estructura\Provincia;

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

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('activo', CheckboxType::class, [
                'required' => false,
                'label' => 'Habilitado'
            ])
            ->add('espacio', EntityType::class, [
                'class' => Espacio::class,
                'choice_label' => 'nombreCorto',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombreCorto', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('plato', EntityType::class, [
                'class' => Plato::class,
                'label' => 'Platos',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombre', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null,
                'multiple' => true,
                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
