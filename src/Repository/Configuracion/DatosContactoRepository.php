<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\DatosContacto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatosContacto>
 *
 * @method DatosContacto|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatosContacto|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatosContacto[]    findAll()
 * @method DatosContacto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatosContactoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatosContacto::class);
    }

    public function add(DatosContacto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(DatosContacto $entity, bool $flush = true): DatosContacto
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(DatosContacto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
