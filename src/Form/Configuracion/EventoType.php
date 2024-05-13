<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\TipoEvento;
use App\Entity\Estructura\Provincia;
//use App\Entity\Personal\Carrera;
//use App\Entity\Personal\NivelEscolar;
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

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('telefonoAuspiciador', TextType::class, [
                'label' => 'Teléfono del auspiciador',
                'required' => false,
                'constraints' => [
                    new NotBlank()
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
            ->add('locacion', TextType::class, [
                'label' => 'Locación',
                'required' => false,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false,
            ])
            ->add('gestionarBuffet', CheckboxType::class, [
                'required' => false,
                'label' => 'Gestionar Buffet'
            ])
            ->add('ambientacion', CheckboxType::class, [
                'required' => false,
                'label' => 'Ambientación'
            ])
            ->add('fecha', TextType::class, [
                'attr' => [
                    'class' => 'date-time-picker'
                ]
            ])
            ->add('tipoEvento', EntityType::class, [
                'label' => 'Tipo de evento',
                'class' => TipoEvento::class,
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
            'data_class' => Evento::class,
        ]);
    }
}
