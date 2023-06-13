<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\Envio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Envio>
 *
 * @method Envio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Envio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Envio[]    findAll()
 * @method Envio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnvioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Envio::class);
    }

    public function add(Envio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Envio $entity, bool $flush = true): Envio
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Envio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
