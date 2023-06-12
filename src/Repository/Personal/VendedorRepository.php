<?php

namespace App\Repository\Personal;

use App\Entity\Personal\Vendedor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vendedor>
 *
 * @method Vendedor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vendedor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vendedor[]    findAll()
 * @method Vendedor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendedorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vendedor::class);
    }

    public function add(Vendedor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(Vendedor $entity, bool $flush = true): Vendedor
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(Vendedor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getVendedores($estructurasNegocio)
    {
        $qb = $this->createQueryBuilder('v')
            ->innerJoin('v.persona', 'qb')
            ->where("qb.activo = true and  qb.estructura IN(:valuesItems)")->setParameter('valuesItems', array_values($estructurasNegocio));
        $qb->orderBy('qb.primerNombre');
        $resul = $qb->getQuery()->getResult();
        return $resul;
    }

    public function getExportarListado($estructurasNegocio)
    {
        $qb = $this->createQueryBuilder('v')
            ->innerJoin('v.persona', 'qb')
            ->select('qb.id, qb.primerNombre, qb.segundoNombre, qb.primerApellido, qb.segundoApellido, qb.activo, qb.carnetIdentidad')
            ->where("qb.activo = true and  qb.estructura IN(:valuesItems)")->setParameter('valuesItems', array_values($estructurasNegocio));
        $qb->orderBy('qb.id', 'desc');
        $resul = $qb->getQuery()->getResult();
        $final = [];
        foreach ($resul as $value) {
            $value['nombreCompleto'] = $value['primerNombre'] . ' ' . $value['segundoNombre'] . ' ' . $value['primerApellido'] . ' ' . $value['segundoApellido'];
            $final[] = $value;
        }
        return $final;
    }
}
