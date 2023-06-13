<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\CausaMovimientoInventario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CausaMovimientoInventario>
 *
 * @method CausaMovimientoInventario|null find($id, $lockMode = null, $lockVersion = null)
 * @method CausaMovimientoInventario|null findOneBy(array $criteria, array $orderBy = null)
 * @method CausaMovimientoInventario[]    findAll()
 * @method CausaMovimientoInventario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CausaMovimientoInventarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CausaMovimientoInventario::class);
    }

    public function add(CausaMovimientoInventario $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(CausaMovimientoInventario $entity, bool $flush = true): CausaMovimientoInventario
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(CausaMovimientoInventario $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
