<?php
	namespace Src\Entity\User;

	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\Common\Collections\ArrayCollection;

	/**
	* Role
	*
	* @ORM\Table(name="role")
	* @ORM\Entity
	*/

	class Role
	{
		/**
		* @var integer
		*
		* @ORM\Column(name="id", type="integer", nullable=false)
		* @ORM\Id
		* @ORM\GeneratedValue(strategy="IDENTITY")
		*/
		private $id;

		/**
		* @var string
		*
		* @ORM\Column(name="name", type="string", length=45, nullable=false)
		*/
		private $name;

		/**
		* @ORM\OneToMany(targetEntity="User", mappedBy="role")
		*/
		protected $users;




		function __construct()
		{
			$this->users = new ArrayCollection();
		}



		/**
	    * Get id
	    *
	    * @return integer
	    */
	    public function getId()
	    {
	        return $this->id;
	    }

	    /**
	     * Set name
	     *
	     * @param string $name
	     *
	     * @return Role
	     */
	    public function setName($name)
	    {
	        $this->name = $name;

	        return $this;
	    }

	    /**
	     * Get name
	     *
	     * @return string
	     */
	    public function getName()
	    {
	        return $this->name;
	    }

	    /**
	     * Add user
	     *
	     * @param \Src\Entity\User\User $user
	     *
	     * @return Role
	     */
	    public function addUser(\Src\Entity\User\User $user)
	    {
	        $this->users[] = $user;

	        return $this;
	    }

	    /**
	     * Remove user
	     *
	     * @param \Src\Entity\User\User $user
	     */
	    public function removeUser(\Src\Entity\User\User $user)
	    {
	        $this->users->removeElement($user);
	    }

	    /**
	     * Get users
	     *
	     * @return \Doctrine\Common\Collections\Collection
	     */
	    public function getUsers()
	    {
	        return $this->users;
	    }
	}
?>