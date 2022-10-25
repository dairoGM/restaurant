<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\TipoRuta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoRuta>
 *
 * @method TipoRuta|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoRuta|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoRuta[]    findAll()
 * @method TipoRuta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoRutaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoRuta::class);
    }

    public function add(TipoRuta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoRuta $entity, bool $flush = true): TipoRuta
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoRuta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
