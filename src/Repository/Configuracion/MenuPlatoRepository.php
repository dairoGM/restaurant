<?php

namespace App\Repository\Configuracion;

use App\Entity\Configuracion\MenuPlato;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuPlato>
 *
 * @method MenuPlato|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuPlato|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuPlato[]    findAll()
 * @method MenuPlato[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuPlatoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuPlato::class);
    }

    public function add(MenuPlato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function edit(MenuPlato $entity, bool $flush = true): MenuPlato
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }

        return $entity;
    }

    public function remove(MenuPlato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listarPlatos($filters = [], $orderBy = [], $limit = null)
    {
        $query = $this->createQueryBuilder('qb')
            ->select('p.id, 
                        p.nombre, 
                        p.precio,                                                  
                        p.activo,                                           
                        p.publico,                                           
                        p.descripcion,
                         p.imagen')
            ->innerJoin('qb.menu', 'm')
            ->innerJoin('qb.plato', 'p');
        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                $query->andWhere("$key = '$value'");
            }
        }
        if (count($orderBy) == 0) {
            $query->orderBy('p.nombre', 'ASC');
        } else {
            foreach ($orderBy as $key => $value) {
                $query->addOrderBy("qb.$key", $value);
            }
        }
//        echo '<pre>';
//        print_r($query->getQuery()->getSQL());
//        die;
        return $query->getQuery()->getResult(1);
    }

}
