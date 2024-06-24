<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\TipoMoneda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoMoneda>
 *
 * @method TipoMoneda|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoMoneda|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoMoneda[]    findAll()
 * @method TipoMoneda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoMonedaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoMoneda::class);
    }

    public function add(TipoMoneda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoMoneda $entity, bool $flush = true): TipoMoneda
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoMoneda $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
