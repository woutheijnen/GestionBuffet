<?php
	namespace Src\Entity\User;

	use Doctrine\ORM\Mapping as ORM;

	/**
	* User
	*
	* @ORM\Table(name="user")
	* @ORM\Entity
	* @ORM\Entity(repositoryClass="Src\Entity\User\UserRepository")
	*/

	class User
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
		* @ORM\Column(name="username", type="string", length=45, nullable=false)
		*/
		private $username;

		/**
		* @var string
		*
		* @ORM\Column(name="password", type="string", length=45, nullable=false)
		*/
		private $password;

		/**
		* @var string
		*
		* @ORM\Column(name="name", type="string", length=50, nullable=false)
		*/
		private $name;

		/**
		* @var string
		*
		* @ORM\Column(name="lastName", type="string", length=50, nullable=false)
		*/
		private $lastName;

		/**
		* @var string
		*
		* @ORM\Column(name="documentType", type="string", length=45, nullable=false)
		*/
		private $documentType;

		/**
		* @var string
		*
		* @ORM\Column(name="document", type="string", length=255, nullable=false)
		*/
		private $document;

		/**
		* @var string
		*
		* @ORM\Column(name="email", type="string", length=255, nullable=false)
		*/
		private $email;

		/**
		* @var string
		*
		* @ORM\Column(name="telephone", type="string", length=45, nullable=false)
		*/
		private $telephone;

		/**
     	* @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     	* @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     	*/
    	private $role;

    	/**
     	* @ORM\ManyToOne(targetEntity="Location", inversedBy="users")
     	* @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     	*/
    	private $location;

    	/**
		* @var boolean
		*
		* @ORM\Column(name="enabled", type="boolean", nullable=false)
		*/
		private $enabled;


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
	     * Set username
	     *
	     * @param string $username
	     *
	     * @return User
	     */
	    public function setUsername($username)
	    {
	        $this->username = $username;

	        return $this;
	    }

			/**
	     * Get username
	     *
	     * @return string
	     */
	    public function getUsername()
	    {
	        return $this->username;
	    }

	    /**
	     * Set password
	     *
	     * @param string $password
	     *
	     * @return User
	     */
	    public function setPassword($password)
	    {
	        $this->password = $password;

	        return $this;
	    }

	    /**
	     * Get password
	     *
	     * @return string
	     */
	    public function getPassword()
	    {
	        return $this->password;
	    }

	    /**
	     * Set name
	     *
	     * @param string $name
	     *
	     * @return User
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
	     * Set lastName
	     *
	     * @param string $lastName
	     *
	     * @return User
	     */
	    public function setLastName($lastName)
	    {
	        $this->lastName = $lastName;

	        return $this;
	    }

	    /**
	     * Get lastName
	     *
	     * @return string
	     */
	    public function getLastName()
	    {
	        return $this->lastName;
	    }

	    /**
	     * Set documentType
	     *
	     * @param string $documentType
	     *
	     * @return User
	     */
	    public function setDocumentType($documentType)
	    {
	        $this->documentType = $documentType;

	        return $this;
	    }

	    /**
	     * Get documentType
	     *
	     * @return string
	     */
	    public function getDocumentType()
	    {
	        return $this->documentType;
	    }

	    /**
	     * Set document
	     *
	     * @param string $document
	     *
	     * @return User
	     */
	    public function setDocument($document)
	    {
	        $this->document = $document;

	        return $this;
	    }

	    /**
	     * Get document
	     *
	     * @return string
	     */
	    public function getDocument()
	    {
	        return $this->document;
	    }

	    /**
	     * Set email
	     *
	     * @param string $email
	     *
	     * @return User
	     */
	    public function setEmail($email)
	    {
	        $this->email = $email;

	        return $this;
	    }

	    /**
	     * Get email
	     *
	     * @return string
	     */
	    public function getEmail()
	    {
	        return $this->email;
	    }

	    /**
	     * Set telephone
	     *
	     * @param string $telephone
	     *
	     * @return User
	     */
	    public function setTelephone($telephone)
	    {
	        $this->telephone = $telephone;

	        return $this;
	    }

	    /**
	     * Get telephone
	     *
	     * @return string
	     */
	    public function getTelephone()
	    {
	        return $this->telephone;
	    }

	    /**
	     * Set role
	     *
	     * @param \Src\Entity\User\Role $role
	     *
	     * @return User
	     */
	    public function setRole(\Src\Entity\User\Role $role = null)
	    {
	        $this->role = $role;

	        return $this;
	    }

	    /**
	     * Get role
	     *
	     * @return \Src\Entity\User\Role
	     */
	    public function getRole()
	    {
	        return $this->role;
	    }

	    /**
	     * Set location
	     *
	     * @param \Src\Entity\User\Location $location
	     *
	     * @return User
	     */
	    public function setLocation(\Src\Entity\User\Location $location = null)
	    {
	        $this->location = $location;

	        return $this;
	    }

	    /**
	     * Get location
	     *
	     * @return \Src\Entity\User\Location
	     */
	    public function getLocation()
	    {
	        return $this->location;
	    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
	}
?>
