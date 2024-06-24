<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\MetodoPago;
use App\Entity\Configuracion\TipoMetodoPago;
use App\Entity\Configuracion\TipoMoneda;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MetodoPagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('numeroTarjeta', TextType::class, [
                'label' => 'Número de tarjeta',
                'required' => false,
            ])
            ->add('telefonoConfirmacion', TextType::class, [
                'label' => 'Teléfono de confirmación'
            ])
            ->add('linkPago', UrlType::class, [
                'label' => 'Link de pago',
                'required' => false,
            ])
            ->add('imagen', FileType::class, array(
                'label' => 'Imagen QR',
                "attr" => array("type" => "file"),
                "required" => false,
                "mapped" => false,

            ))
            ->add('tipoMoneda', EntityType::class, [
                'label' => 'Tipo de moneda',
                'class' => TipoMoneda::class,
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombre', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('tipoMetodoPago', EntityType::class, [
                'label' => 'Tipo de método de pago',
                'class' => TipoMetodoPago::class,
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.activo = true')->orderBy('u.nombre', 'ASC');
                },
                'placeholder' => 'Seleccione',
                'empty_data' => null
            ])
            ->add('activo', CheckboxType::class, [
                'required' => false,
                'label' => 'Habilitado'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MetodoPago::class,
        ]);
    }
}
