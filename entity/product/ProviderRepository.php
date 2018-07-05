<?php namespace Src\Entity\Product;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

class ProviderRepository extends EntityRepository
{
    public function findOrderedByName($firstResult, $maxResults)
    {
        return $GLOBALS['em']
        ->createQuery(
            'SELECT p FROM Src\Entity\Product\Provider p ORDER BY p.name ASC'
        )
        ->setFirstResult($firstResult)
        ->setMaxResults($maxResults)
        ->getResult();
    }
    public function findAllOrderedByName()
    {
        return $GLOBALS['em']
        ->createQuery(
            'SELECT p FROM Src\Entity\Product\Provider p ORDER BY p.name ASC'
        )
        ->getResult();
    }

}