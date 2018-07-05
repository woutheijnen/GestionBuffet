<?php namespace Src\Controller;

use Src\Entity\Sale;
use Src\Entity\Configuration;
use Doctrine\ORM\EntityRepository;
use Exception;

class SaleController {

    private $url;

    public function __construct(){
        $this->url = $_SESSION['base_path'];
    }

    public function index() {
       header('Location: /index.php/sale/listar');
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
          
      $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\Purchase\Sale')-> findAll());
      $numberOfPages= ceil($numberOfItems / $maxResults);

      /* Paginacion -- calcular numero de paginas */
      $sales = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Sale')->findOrderedByName($firstResult, $maxResults);
      $plantilla = $GLOBALS['twig']-> loadTemplate('purchase/sales.html.twig');
      $plantilla-> display(array('sales' => $sales, 'accion' => "Vendas", 'actualPage' => $page, 'numberOfPages' => $numberOfPages,'url'=>$this->url));
    }

    public function updateSale($sale, $data){
      try {
          $sale->setCuit($data['sale-cuit']);
          $sale->setPath_of_scan($data['sale-path_of_scan']);
          $sale->setProduct_list($data['sale-product_list']);
          $GLOBALS['em']->persist($sale);
          $GLOBALS['em']->flush();
          //var_dump($sale);
            return true;
          } catch (Exception $e) {
              return false;
          }
    }

    public function addSale(){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $error = $this->updateSale(new \Src\Entity\Purchase\Sale(), $_POST);
            if (!$error){
              //avisar de que hubo un problema al guardar, redirigir al formulario
              $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
              $plantilla-> display(array('message' => "Error, no se pudo guardar la venta"));;
            }else{
              //flash data venda guardado
            }
            header('Location: /index.php/sale/listar');
        }else{
            $products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findAll();
            $plantilla = $GLOBALS['twig']-> loadTemplate('purchase/add-sale.html.twig');
            $data = array(
              'products' => $products,
              'action' => "addSale",
            );
            $plantilla-> display($data);
        }
    }

    public function editSale($idSale){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $sale = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Sale')->find($idSale);
            $error = $this->updateSale($sale, $_POST);
            if (!$error){
              //avisar de que hubo un problema al guardar, redirigir al formulario
              $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
              $plantilla-> display(array('message' => "Error, no se pudo guardar la venta"));;
            }else{
                //flash data venda guardado
            }
            header('Location: /index.php/sale/listar');
        }else{
            $sale = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Sale')->find($idSale);
            $products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findAll();
            $plantilla = $GLOBALS['twig']-> loadTemplate('purchase/add-sale.html.twig');
            $data = array(
              'products' => $products,
              'action' => "editSale/".$idSale,
              'sale' => $sale,
            );
            $plantilla-> display($data);

        }
    }

    public function deleteSale($idSale){
        $sale = $GLOBALS['em']->getRepository('Src\Entity\Purchase\Sale')->find($idSale);
        try {
          if (!$sale) {
          throw new \Exception('Venda no encontrado: '.$idSale);
        } else {
          $GLOBALS['em']->remove($sale);
          $GLOBALS['em']->flush();
          header('Location: ' . $this->url . 'listar');
        }
      } catch (\Exception $e) {
        // $e->getMessage();
        $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
        $plantilla-> display(array('message' => "Error, no se pudo eliminar la venta"));;
   		}
    }
}
