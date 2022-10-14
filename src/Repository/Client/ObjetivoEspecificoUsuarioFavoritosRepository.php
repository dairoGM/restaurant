<?php

namespace App\Repository\Client;

use App\Entity\Client\ObjetivoEspecificoUsuarioFavoritos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ObjetivoEspecificoUsuarioFavoritos>
 *
 * @method ObjetivoEspecificoUsuarioFavoritos|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjetivoEspecificoUsuarioFavoritos|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjetivoEspecificoUsuarioFavoritos[]    findAll()
 * @method ObjetivoEspecificoUsuarioFavoritos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetivoEspecificoUsuarioFavoritosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjetivoEspecificoUsuarioFavoritos::class);
    }

    public function add(ObjetivoEspecificoUsuarioFavoritos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ObjetivoEspecificoUsuarioFavoritos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ObjetivoEspecificoUsuarioFavoritos[] Returns an array of ObjetivoEspecificoUsuarioFavoritos objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ObjetivoEspecificoUsuarioFavoritos
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
