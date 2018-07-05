<?php namespace Src\Controller;

use Src\Entity\Product;
use Src\Entity\Configuration;
use Doctrine\ORM\EntityRepository;
use Exception;

class ProductController {

    private $url;

    public function __construct(){
        $this->url = $_SESSION['base_path'];
    }

    public function index() {
      //$products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findAllOrderedByName();
     // $plantilla = $GLOBALS['twig']-> loadTemplate('product/products.html.twig');
     // $plantilla-> display(array('products' => $products));
       header('Location: /index.php/product/listar');
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
          
      $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\Product\Product')-> findAll());
      $numberOfPages= ceil($numberOfItems / $maxResults);

      /* Paginacion -- calcular numero de paginas */
      $products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findOrderedByName($firstResult, $maxResults);
      $plantilla = $GLOBALS['twig']-> loadTemplate('product/products.html.twig');
      $plantilla-> display(array('products' => $products, 'accion' => "Productos", 'actualPage' => $page, 'numberOfPages' => $numberOfPages,'url'=>$this->url));
    }

    public function updateProduct($product, $data){
      try {
          $product->setName($data['product-name']);
          $product->setBrand($data['brand']);
          $product->setCode($data['code']);
          if (isset($data['category'])){
            $category = $GLOBALS['em']->getRepository('Src\Entity\Product\Category')->find($data['category']);
            $product->setCategory($category);
          }

          $product->setStock($data['amount']);
          $product->setMinimumStock($data['minimum-amount']);

          if (isset($data['provider'])){
            $provider = $GLOBALS['em']->getRepository('Src\Entity\Product\Provider')->find($data['provider']);
            $product->setProvider($provider);
          }
          $product->setPrice($data['unit-price']);
          $GLOBALS['em']->persist($product);
          $GLOBALS['em']->flush();
          //var_dump($product);
            return true;
          } catch (Exception $e) {
              return false;
          }
    }

    public function addProduct(){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $error = $this->updateProduct(new Product\Product(), $_POST);
            if (!$error){
              //avisar de que hubo un problema al guardar, redirigir al formulario

              $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
              $plantilla-> display(array('message' => "Error, no se pudo guardar el producto"));
            }else{
              //flash data producto guardado
            }
            header('Location: /index.php/product/listar');
        }else{
            $categories = $GLOBALS['em']->getRepository('Src\Entity\Product\Category')->findAll();
            $providers = $GLOBALS['em']->getRepository('Src\Entity\Product\Provider')->findAll();
            $plantilla = $GLOBALS['twig']-> loadTemplate('product/add-product.html.twig');
            $data = array(
              'providers' => $providers,
              'categories' => $categories,
              'action' => "addProduct",
            );
            $plantilla-> display($data);
        }
    }

    public function editProduct($idProduct){
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $product = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->find($idProduct);
            $error = $this->updateProduct($product, $_POST);
            if (!$error){
              //avisar de que hubo un problema al guardar, redirigir al formulario
              $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
              $plantilla-> display(array('message' => "Error,no se pudo guardar el producto"));
            }else{
                //flash data producto guardado
            }
            header('Location: /index.php/product/listar');
        }else{
            $product = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->find($idProduct);
            $categories = $GLOBALS['em']->getRepository('Src\Entity\Product\Category')->findAll();
            $providers = $GLOBALS['em']->getRepository('Src\Entity\Product\Provider')->findAll();
            $plantilla = $GLOBALS['twig']-> loadTemplate('product/add-product.html.twig');
            $data = array(
              'providers' => $providers,
              'categories' => $categories,
              'action' => "editProduct/".$idProduct,
              'product' => $product,
            );
            $plantilla-> display($data);

        }
    }

    public function deleteProduct($idProduct){
        $product = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->find($idProduct);
        try {
          if (!$product) {
          throw new \Exception('Producto no encontrado: '.$idProduct);
        } else {
          $GLOBALS['em']->remove($product);
          $GLOBALS['em']->flush();
          header('Location: ' . $this->url . 'listar');
        }
      } catch (\Exception $e) {
       // $e->getMessage();
        $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
        $plantilla-> display(array('message' => "Error,no se pudo eliminar el producto"));

   		}
    }

    public function minimumStock(){
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
          
      $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\Product\Product')-> findAllWithMinimumStock());
      $numberOfPages= ceil($numberOfItems / $maxResults);

      /* Paginacion -- calcular numero de paginas */

      $products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findWithMinimumStock($firstResult, $maxResults);
      $plantilla = $GLOBALS['twig']-> loadTemplate('product/products.html.twig');
      $plantilla-> display(array('products' => $products, 'accion' => "Listado de productos con stock minimo", 'actualPage' => $page, 'numberOfPages' => $numberOfPages));
    }

    public function missingProducts(){
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
          
      $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\Product\Product')-> findAllTheMissingProducts());
      $numberOfPages= ceil($numberOfItems / $maxResults);

      /* Paginacion -- calcular numero de paginas */
      $products = $GLOBALS['em']->getRepository('Src\Entity\Product\Product')->findTheMissingProducts($firstResult, $maxResults);
      $plantilla = $GLOBALS['twig']-> loadTemplate('product/products.html.twig');
      $plantilla-> display(array('products' => $products, 'accion' => "Listado de productos faltantes", 'actualPage' => $page, 'numberOfPages' => $numberOfPages));
    }
}
