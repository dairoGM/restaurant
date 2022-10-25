<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\TipoIdentificadorFiscal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoIdentificadorFiscal>
 *
 * @method TipoIdentificadorFiscal|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoIdentificadorFiscal|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoIdentificadorFiscal[]    findAll()
 * @method TipoIdentificadorFiscal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoIdentificadorFiscalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoIdentificadorFiscal::class);
    }

    public function add(TipoIdentificadorFiscal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(TipoIdentificadorFiscal $entity, bool $flush = true): TipoIdentificadorFiscal
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(TipoIdentificadorFiscal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
