<?php namespace Src\Controller;

use Src\Entity\Purchase;
use Src\Entity\Configuration;
use Doctrine\ORM\EntityRepository;
use Exception;

class PurchaseController {

    private $url;

    public function __construct(){
        $this->url = $_SESSION['base_path'];
    }

    public function index() {
       header('Location: /index.php/purchase/listar');
    }

    public function listar(){
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
          
      $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\Purchase\Purchase')-> findAll());
      $numberOfPages= ceil($numberOfItems / $maxResults);

      /* Paginacion -- calcular numero de paginas */
      $purchases = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Purchase')->findOrderedByName($firstResult, $maxResults);
      $plantilla = $GLOBALS['twig']-> loadTemplate('purchase/purchases.html.twig');
      $plantilla-> display(array('purchases' => $purchases, 'accion' => "Compras", 'actualPage' => $page, 'numberOfPages' => $numberOfPages,'url'=>$this->url));
    }

    public function updatePurchase($purchase, $data){
      try {
          $purchase->setCuit($data['purchase-cuit']);
          $purchase->setPath_of_scan($data['purchase-path_of_scan']);
          $purchase->setProduct_list($data['purchase-product_list']);

          $GLOBALS['em']->persist($purchase);
          $GLOBALS['em']->flush();
          //var_dump($purchase);
            return true;
          } catch (Exception $e) {
              return false;
          }
    }

    public function addPurchase(){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $error = $this->updatePurchase(new Purchase\Purchase(), $_POST);
            if (!$error){
              //avisar de que hubo un problema al guardar, redirigir al formulario
              $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
              $plantilla-> display(array('message' => "Error, no se pudo guardar la compra"));;
            }else{
              //flash data compra guardado
            }
            header('Location: /index.php/purchase/listar');
        }else{
            $products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findAll();
            $plantilla = $GLOBALS['twig']-> loadTemplate('purchase/add-purchase.html.twig');
            $data = array(
              'products' => $products,
              'action' => "addPurchase",
            );
            $plantilla-> display($data);
        }
    }

    public function editPurchase($idPurchase){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $purchase = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Purchase')->find($idPurchase);
            $error = $this->updatePurchase($purchase, $_POST);
            if (!$error){
              //avisar de que hubo un problema al guardar, redirigir al formulario
             $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
              $plantilla-> display(array('message' => "Error, no se pudo guardar la compra"));;
            }else{
                //flash data compra guardado
            }
            header('Location: /index.php/purchase/listar');
        }else{
            $purchase = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Purchase')->find($idPurchase);
            $products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findAll();
            $plantilla = $GLOBALS['twig']-> loadTemplate('purchase/add-purchase.html.twig');
            $data = array(
              'products' => $products,
              'action' => "editPurchase/".$idPurchase,
              'purchase' => $purchase,
            );
            $plantilla-> display($data);

        }
    }

    public function deletePurchase($idPurchase){
        $purchase = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Purchase')->find($idPurchase);
        try {
          if (!$purchase) {
          throw new \Exception('Compra no encontrado: '.$idPurchase);
        } else {
          $GLOBALS['em']->remove($purchase);
          $GLOBALS['em']->flush();
          header('Location: ' . $this->url . 'listar');
        }
      } catch (\Exception $e) {
        // $e->getMessage();
        $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
       $plantilla-> display(array('message' => "Error, no se pudo eliminar la compra"));;
   		}
    }
}
