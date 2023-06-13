<?php

namespace App\Form\Catalogo;

use App\Entity\Catalogo\ClasificacionRuta;
use App\Entity\Catalogo\Compania;
use App\Entity\Catalogo\Region;
use App\Entity\Catalogo\Ruta;
use App\Entity\Catalogo\TipoRuta;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RutaType extends AbstractType
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
            ->add('keyRuta', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'allowEmptyString' => true,
                        'maxMessage' => 'El número máximo de caracteres permitidos es 50',
                        'max' => 50,
                    ]),
                ]
            ])
            ->add('keyRutaNueva', TextType::class, [
                'label' => 'Key ruta nueva',
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
            ->add('region', EntityType::class, [
                'label' => 'Región',
                'class' => Region::class,
                'choice_label' => 'region',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.region', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('clasificacionRuta', EntityType::class, [
                'label' => 'Clasificación de ruta',
                'class' => ClasificacionRuta::class,
                'choice_label' => 'clasificacionRuta',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.clasificacionRuta', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('tipoRuta', EntityType::class, [
                'label' => 'Tipo de ruta',
                'class' => TipoRuta::class,
                'choice_label' => 'tipoRuta',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.tipoRuta', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('compania', EntityType::class, [
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
            'data_class' => Ruta::class,
        ]);
    }
}
