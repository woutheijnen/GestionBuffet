<?php namespace Src\Entity\Product;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
//use Src\Entity\Product\Product;

class ProductRepository extends EntityRepository
{
    public function findOrderedByName($firstResult, $maxResults)
    {
        return $GLOBALS['em']
        ->createQuery(
            'SELECT p FROM Src\Entity\Product\Product p ORDER BY p.name ASC'
        )
        ->setFirstResult($firstResult)
        ->setMaxResults($maxResults)
        ->getResult();
    }
    public function findAllOrderedByName()
    {
        return $GLOBALS['em']
        ->createQuery(
            'SELECT p FROM Src\Entity\Product\Product p ORDER BY p.name ASC'
        )
        ->getResult();
    }
   

    public function findWithMinimumStock($firstResult, $maxResults)
    {
    	return $GLOBALS['em']
    		->createQuery(
    			'SELECT p FROM Src\Entity\Product\Product p WHERE p.stock = p.minimumStock ORDER BY p.name ASC'
    		)
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
    		->getResult();
    }
    public function findAllWithMinimumStock()
    {
        return $GLOBALS['em']
            ->createQuery(
                'SELECT p FROM Src\Entity\Product\Product p WHERE p.stock = p.minimumStock ORDER BY p.name ASC'
            )
            ->getResult();
    }

    public function findTheMissingProducts($firstResult, $maxResults)
    {
        return $GLOBALS['em']
            ->createQuery(
                'SELECT p FROM Src\Entity\Product\Product p WHERE p.stock = 0 ORDER BY p.name ASC'
            )
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
            ->getResult();
    }

    public function findAllTheMissingProducts()
    {
        return $GLOBALS['em']
            ->createQuery(
                'SELECT p FROM Src\Entity\Product\Product p WHERE p.stock = 0 ORDER BY p.name ASC'
            )
            ->getResult();
    }
}