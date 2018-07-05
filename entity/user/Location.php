<?php
	namespace Src\Entity\User;

	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\Common\Collections\ArrayCollection;

	/**
	* Location
	*
	* @ORM\Table(name="location")
	* @ORM\Entity
	*/

	class Location
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
		* @var string
		*
		* @ORM\Column(name="description", type="string", length=255, nullable=true)
		*/
		private $description;

		/**
		* @ORM\OneToMany(targetEntity="User", mappedBy="location")
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
	     * @return Location
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
	     * Set description
	     *
	     * @param string $description
	     *
	     * @return Location
	     */
	    public function setDescription($description)
	    {
	        $this->description = $description;

	        return $this;
	    }

	    /**
	    * Get description
	    *
	    * @return string
	    */
	    public function getDescription()
	    {
	        return $this->description;
	    }

	    /**
	     * Add user
	     *
	     * @param \Src\Entity\User\User $user
	     *
	     * @return Location
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