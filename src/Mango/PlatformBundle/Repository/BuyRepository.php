<?php

namespace Mango\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * BuyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BuyRepository extends \Doctrine\ORM\EntityRepository
{
	public function getBuys($page, $nbPerPage){  //arguments pour la pagination
        $query = $this->createQueryBuilder('b')
                     ->where('b.published = 1')  //On ne sélectionne que les annonces publiées
                     ->leftJoin('b.image', 'i')  
                     ->addSelect('i')
                     ->leftJoin('b.city', 'c')  
                     ->addSelect('c')
                     ->leftJoin('b.type', 't')  
                     ->addSelect('t')
                     ->orderBy('b.date', 'DESC')
                     ->getQuery();

        $query->setFirstResult(($page-1)*$nbPerPage) //Commencement
              ->setMaxResults($nbPerPage); //Nb par page

        return new Paginator($query, true);
    }

    public function getBuysByUser($userId){  //Recherche par utilisateur
        $query = $this->createQueryBuilder('b')
                     ->where('b.userId = :user_id')
                     ->setParameter('user_id', $userId)
                     ->leftJoin('b.image', 'i')  
                     ->addSelect('i')
                     ->leftJoin('b.city', 'c')  
                     ->addSelect('c')
                     ->orderBy('b.date', 'DESC')
                     ->getQuery()
                     ->getResult();

        return $query;
    }

    public function findBuyWithRegion($id){      //Récupération à partir de la région (moins de requête)
        $query = $this->createQueryBuilder('b')
                ->select('b, t, c, d, r')
                ->join('b.type', 't')
                ->join('b.city', 'c')
                ->join('c.departement', 'd')
                ->join('d.region', 'r')
                ->where('b.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();
        return $query;
    }
}
