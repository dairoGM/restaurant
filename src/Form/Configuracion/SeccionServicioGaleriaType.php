<?php

namespace App\Form\Configuracion;

use App\Entity\Configuracion\ComentarioEspacio;
use App\Entity\Configuracion\Espacio;
use App\Entity\Configuracion\Evento;
use App\Entity\Configuracion\SeccionServicio;
use App\Entity\Configuracion\Servicio;
use App\Entity\Configuracion\TipoEvento;

//use App\Entity\Estructura\Provincia;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SeccionServicioGaleriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imagen', FileType::class, array(
                "attr" => array("type" => "file"),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Este campo no puede estar vacío.',
                    ])
                ],
                "mapped" => false

            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeccionServicio::class,
        ]);
    }
}
