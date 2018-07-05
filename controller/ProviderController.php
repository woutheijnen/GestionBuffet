<?php namespace Src\Controller;

use Src\Entity\Product;
use Src\Entity\Configuration;
use Doctrine\ORM\EntityRepository;

class ProviderController {

    private $url;

    public function __construct(){
        $this->url = $_SESSION['base_path'];
    }

    public function index() {
        header('Location: ' . $this->url . 'listar');

    }

    public function listar($pagina){
      /* Paginacion -- que elementos mostrar */
      $page=0;
      $firstResult=0;
      $maxResultsQuery = ($GLOBALS['em']->getRepository('Src\Entity\Configuration\Configuration')->find(1));
      $maxResults = $maxResultsQuery->getNumberOfItems();
            
      if (isset($_GET['page'])) {
        $page=$_GET['page'];
        $firstResult=$page * $maxResults;
      }
      /* Paginacion -- que elementos mostrar */
      /* Paginacion -- calcular numero de paginas */
          
      $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\Product\Provider')-> findAll());
      $numberOfPages= ceil($numberOfItems / $maxResults);

      /* Paginacion -- calcular numero de paginas */
      $providers = $GLOBALS['em']->getRepository('Src\Entity\Product\Provider')->findOrderedByName($firstResult, $maxResults);
      $plantilla = $GLOBALS['twig']->loadTemplate('product/providers.html.twig');
      $plantilla->display(array('providers' => $providers, 'actualPage' => $page, 'numberOfPages' => $numberOfPages, 'url'=>$this->url));
    }

    public function addProvider(){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
          // es mejor asi o el isset submit??

          // faltan validaciones lado servidor
          $provider = new Product\Provider();
          if ($_POST['id']) {
            $provider = $GLOBALS['em']->getRepository('Src\Entity\Product\Provider')->find($_POST['id']);
          }
          if (isset($_POST['name'])) {
              $provider->setName($_POST['name']);
              $provider->setCuit($_POST['cuit']);
              $provider->setEmail($_POST['email']);
              $provider->setPhone($_POST['phone']);
              $provider->setAddress($_POST['address']);
              $provider->setDescription($_POST['description']);
//              $provider->setProducts($_POST['products']);
              $GLOBALS['em']->persist($provider);
              $GLOBALS['em']->flush();
              header('Location: ' . $this->url . 'listar');
          }else {
            //cargar formulario con los campos que lleno originalmente, +mensaje de error correspondiente
          }
        }else{
            $plantilla = $GLOBALS['twig']->loadTemplate('product/add-provider.html.twig');
            $plantilla-> display(['url'=>$this->url]);
        }
    }

    public function editProvider($id) {
      $provider = $GLOBALS['em']->getRepository('Src\Entity\Product\Provider')->find($id);
      if (!$provider) {
        //devolver error
        header('Location: ' . $this->url . 'listar');
      }
      $plantilla = $GLOBALS['twig']->loadTemplate('product/add-provider.html.twig');
      $plantilla->display(array('provider' => $provider));
    }

    public function deleteProvider($idProvider)
    {
    	$provider = $GLOBALS['em']->getRepository('Src\Entity\Product\Provider')->find($idProvider);
    		try {
    			if (!$provider) {
    				throw new \Exception('No provider found: '.$idProvider);
    			} else {
    				$GLOBALS['em']->remove($provider);
    				$GLOBALS['em']->flush();
    				header('Location: ' . $this->url . 'listar');
    			}
    		} catch (\Exception $e) {
            $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
            $plantilla-> display(array('message' => "Error, el proveedotr no se pudo eliminar."));
    		}
    }

}
