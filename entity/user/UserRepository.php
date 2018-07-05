<?php namespace Src\Entity\User;

	use Doctrine\ORM\EntityRepository;
	use Doctrine\ORM\Mapping as ORM;

	class UserRepository extends EntityRepository
	{
		public function findOrderedByName($firstResult, $maxResults)
		{
			return $GLOBALS['em']
            ->createQuery(
                'SELECT u FROM Src\Entity\User\User u ORDER BY u.name ASC'
            )
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
            ->getResult();
		}

		public function findAllOrderedByName()
		{
			return $GLOBALS['em']
            ->createQuery(
                'SELECT u FROM Src\Entity\User\User u ORDER BY u.name ASC'
            )
            ->getResult();
		}

		public function findByEnabled()
		{
			//echo "$state";die();
			return $GLOBALS['em']
			->createQuery(
				'SELECT u FROM Src\Entity\User\User u WHERE u.enabled = True ORDER BY u.name ASC'
			)
			->getResult();

		}
		

		public function findByEnabledPaged($firstResult, $maxResults)
		{
			//	echo "$state";die();
			return $GLOBALS['em']
			->createQuery(
				'SELECT u FROM Src\Entity\User\User u WHERE u.enabled = True ORDER BY u.name ASC'
			)
			->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
			->getResult();
		}

		public function findByDisabled()
		{
			//echo "$state";die();
			return $GLOBALS['em']
			->createQuery(
				'SELECT u FROM Src\Entity\User\User u WHERE u.enabled = False ORDER BY u.name ASC'
			)
			->getResult();

		}
		

		public function findByDisabledPaged($firstResult, $maxResults)
		{
			//	echo "$state";die();
			return $GLOBALS['em']
			->createQuery(
				'SELECT u FROM Src\Entity\User\User u WHERE u.enabled = False ORDER BY u.name ASC'
			)
			->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
			->getResult();
		}


	}

?>
