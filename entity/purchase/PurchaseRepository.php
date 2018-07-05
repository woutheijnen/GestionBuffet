<?php namespace Src\Entity\Purchase;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
//use Src\Entity\Purchase\Purchase;

class PurchaseRepository extends EntityRepository
{
    public function findOrderedByName($firstResult, $maxResults)
    {
        return $GLOBALS['em']
        ->createQuery(
            'SELECT p FROM Src\Entity\Purchase\Purchase p ORDER BY p.cuit ASC'
        )
        ->setFirstResult($firstResult)
        ->setMaxResults($maxResults)
        ->getResult();
    }
    public function findAllOrderedByName()
    {
        return $GLOBALS['em']
        ->createQuery(
            'SELECT p FROM Src\Entity\Purchase\Purchase p ORDER BY p.cuit ASC'
        )
        ->getResult();
    }
}