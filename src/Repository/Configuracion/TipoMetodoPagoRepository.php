<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoMetodoPago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoMetodoPago>
 *
 * @method TipoMetodoPago|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoMetodoPago|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoMetodoPago[]    findAll()
 * @method TipoMetodoPago[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoMetodoPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoMetodoPago::class);
    }

    public function add(TipoMetodoPago $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoMetodoPago $entity, bool $flush = true): TipoMetodoPago
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoMetodoPago $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
