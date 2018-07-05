<?php 
	namespace Src\Entity\Configuration;
	use Doctrine\ORM\Mapping as ORM;
	/**
	* Configuration
	*
	* @ORM\Table(name="configuration")
	* @ORM\Entity
	*/

	class Configuration{
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
		* @ORM\Column(name="title", type="string", length=255, nullable=false)
		*/
		private $title;

		/**
		* @var integer
		*
		* @ORM\Column(name="numberOfItems", type="integer", nullable=false)
		*/
		private $numberOfItems;

		/**
		* @var boolean
		*
		* @ORM\Column(name="enabledSite", type="boolean", nullable=false)
		*/
		private $enabledSite;

		/**
		* @var string
		*
		* @ORM\Column(name="disablingMessage", type="string", length=255, nullable=false)
		*/
		private $disablingMessage;


		function __construct()
		{
			$this->title ='unNombre';
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
     * Set title
     *
     * @param string $title
     *
     * @return Configuration
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set numberOfItems
     *
     * @param integer $numberOfItems
     *
     * @return Configuration
     */
    public function setNumberOfItems($numberOfItems)
    {
        $this->numberOfItems = $numberOfItems;

        return $this;
    }

    /**
     * Get numberOfItems
     *
     * @return integer
     */
    public function getNumberOfItems()
    {
        return $this->numberOfItems;
    }

    /**
     * Set enabledSite
     *
     * @param boolean $enabledSite
     *
     * @return Configuration
     */
    public function setEnabledSite($enabledSite)
    {
        $this->enabledSite = $enabledSite;

        return $this;
    }

    /**
     * Get enabledSite
     *
     * @return boolean
     */
    public function getEnabledSite()
    {
        return $this->enabledSite;
    }

    /**
     * Set disablingMessage
     *
     * @param string $disablingMessage
     *
     * @return Configuration
     */
    public function setDisablingMessage($disablingMessage)
    {
        $this->disablingMessage = $disablingMessage;

        return $this;
    }

    /**
     * Get disablingMessage
     *
     * @return string
     */
    public function getDisablingMessage()
    {
        return $this->disablingMessage;
    }
	}
?>