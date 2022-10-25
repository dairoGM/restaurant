<?php

namespace App\Repository\Catalogo;

use App\Entity\Catalogo\RutaCliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RutaCliente>
 *
 * @method RutaCliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method RutaCliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method RutaCliente[]    findAll()
 * @method RutaCliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RutaClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RutaCliente::class);
    }
  
    public function add(RutaCliente $entity, bool $flush = true): RutaCliente
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }
  
    public function edit(RutaCliente $entity, bool $flush = true): RutaCliente
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(RutaCliente $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
