<?php

namespace App\Repository\Restaurant;

use App\Entity\Restaurant\Perfil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Perfil>
 *
 * @method Perfil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Perfil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Perfil[]    findAll()
 * @method Perfil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PerfilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Perfil::class);
    }

    public function add(Perfil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Perfil $entity, bool $flush = true): Perfil
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Perfil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarPerfils()
    {
        $qb = $this->createQueryBuilder('qb')
            ->select('qb.id, 
                        qb.nombre, 
                        qb.activo, 
                        qb.fecha, 
                        qb.orden, 
                        qb.locacion, 
                        qb.telefonoAuspiciador, 
                        qb.cantidadParticipantes, 
                        qb.gestionarBuffet, 
                        qb.ambientacion, 
                        qb.descripcion, 
                        te.nombre as nombreTipoPerfil, 
                        te.id as idTipoPerfil')
            ->innerJoin('qb.tipoPerfil', 'te');

        $qb->orderBy('qb.orden');
        $resul = $qb->getQuery()->getResult();

        return $resul;
    }
}
