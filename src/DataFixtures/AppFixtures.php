<?php

namespace App\DataFixtures;

use App\Entity\Catalogo\Pais;
use App\Entity\Configuracion\DatosContacto;
use App\Entity\Configuracion\Sobre;

use App\Entity\Configuracion\RedSocial;
use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $em;
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $this->em = $em;
        $this->passwordEncoder = $encoder;
        $this->hasher = $hasher;
    }



    public function load(ObjectManager $manager)
    {

        $redesSociales = ['Facebook', 'G+', 'Instagram', 'Youtube', 'Twitter', 'TikTok', 'LinkedIn', 'Pinterest', 'Messenger', 'Snapchat', 'Reddit'];
        foreach ($redesSociales as $value) {
            $entidad = new RedSocial();
            $entidad->setNombre($value);
            $entidad->setActivo(true);
            $manager->persist($entidad);
        }

        $datosContacto = new DatosContacto();
        $datosContacto->setCorreo('sitio@sitio.com');
        $datosContacto->setTelefono('07 888 8888');
        $datosContacto->setTelefonoCelular('+53 88888888');
        $manager->persist($datosContacto);


        $sobre = new Sobre();
        $sobre->setNombre('Sobre');
        $sobre->setDescripcion('');
        $manager->persist($sobre);

        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setRole('ROLE_ADMIN');
        $password = $this->hasher->hashPassword($user, '123');
        $user->setPassword($password);
        $manager->persist($user);





        $manager->flush();
    }

}