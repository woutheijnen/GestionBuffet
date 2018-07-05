<?php
	namespace Src\Controller;

	use Src\Entity\User;
    use Src\Entity\Configuration;
	use Doctrine\ORM\EntityRepository;
    use Exception;

	class UserController {

        private $url;

        public function __construct(){
            $this->url = $_SESSION['base_path'];
        }
		public function index() {
        	header('Location: /index.php/user/listar');

    	}
		public function listar(){
            /* Paginacion -- que elementos mostrar */
            $page=0;
            $firstResult=0;
            $maxResultsQuery= ($GLOBALS['em']->getRepository('Src\Entity\Configuration\Configuration')->find(1));
			$maxResults = $maxResultsQuery->getNumberOfItems();
            
            if (isset($_GET['page'])) {
                $page=$_GET['page'];
                $firstResult=$page * $maxResults;
            }
            /* Paginacion -- que elementos mostrar */
            /* Paginacion -- calcular numero de paginas */
          
            $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\User\User')-> findByEnabled());

            $numberOfPages= ceil($numberOfItems / $maxResults);

            /* Paginacion -- calcular numero de paginas */
        	$users = $GLOBALS['em']->getRepository('Src\Entity\User\User')->findByEnabledPaged($firstResult, $maxResults);
        	$plantilla = $GLOBALS['twig']-> loadTemplate('user/users.html');
        	$plantilla-> display(array('users' => $users, 'actualPage' => $page, 'numberOfPages' => $numberOfPages, 'url'=>$this->url));
    	}

    	public function addUser(){
            if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
                $user = new User\User();
                if ($_POST['id']) {
                    $user = $GLOBALS['em']->getRepository('Src\Entity\User\User')->find($_POST['id']);
                }
                /* Validaciones */
                if (isset($_POST['username']) &&
                 isset($_POST['password']) &&
                 isset($_POST['password2']) &&
                 isset($_POST['name']) &&
                 isset($_POST['last-name']) &&
                 isset($_POST['document-type']) &&
                 isset($_POST['document']) &&
                 isset($_POST['email']) &&
                 isset($_POST['telephone'])) {
                    if ($_POST['password'] == $_POST['password2']) {
                        /* Seteado */
    			 		$user->setUsername($_POST['username']);
                        $pass= md5($_POST['password']);//HASH
    			 		$user->setPassword($pass);
    			 		$user->setName($_POST['name']);
    			 		$user->setLastName($_POST['last-name']);
    			 		$user->setDocumentType($_POST['document-type']);
    			 		$user->setDocument($_POST['document']);
    			 		$user->setEmail($_POST['email']);
    			 		$user->setTelephone($_POST['telephone']);
                        $user->setEnabled(1);

    			 		if (isset($_POST['role'])) {
    			 			$role = $GLOBALS['em']->getRepository('Src\Entity\User\Role')->find($_POST['role']);
                			$user->setRole($role);
                			if (isset($_POST['location'])) {
                				$location = $GLOBALS['em']->getRepository('Src\Entity\User\Location')->find($_POST['location']);
                				$user->setLocation($location);

                				$GLOBALS['em']->persist($user);
					            $GLOBALS['em']->flush();
					            header('Location: ' . $this->url . 'listar');
                			}else{
                                $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
                                $plantilla-> display(array('message' => "Error, ubicaci&oacute;n inexistente."));
                            }
    			 		}else{
                            $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
                            $plantilla-> display(array('message' => "Error, rol inexistente."));
                        }
                    }else{
                        $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');        
                        $plantilla-> display(array('message' => "Error, datos incorrectos"));
                    }
    			 }
    		}else{
    			$roles = $GLOBALS['em']->getRepository('Src\Entity\User\Role')->findAll();
	            $locations = $GLOBALS['em']->getRepository('Src\Entity\User\Location')->findAll();
	            $plantilla = $GLOBALS['twig']-> loadTemplate('user/add-user.html');
	            $data = array(
	              'roles' => $roles,
	              'locations' => $locations,
	              ,'url'=>$this->url
	            );
	            $plantilla-> display($data);
    		}

    	}


        public function editUser($id){
            $user = $GLOBALS['em']->getRepository('Src\Entity\User\User')->find($id);
            $roles = $GLOBALS['em']->getRepository('Src\Entity\User\Role')->findAll();
            $locations = $GLOBALS['em']->getRepository('Src\Entity\User\Location')->findAll();
            if (!$user) {
                header('Location: ' . $this->url . 'listar');
            }
            $plantilla = $GLOBALS['twig']->loadTemplate('user/add-user.html');
            $plantilla->display(array('user' => $user, 'roles' => $roles, 'locations' => $locations));
        }

        public function deleteUser($id){
            $user = $GLOBALS['em']->getRepository('Src\Entity\User\User')->find($id);
            try {
                if (!$user) {
                    throw new \Exception('No user found: '.$id);
                } else {
                    $GLOBALS['em']->remove($user);
                    $GLOBALS['em']->flush();
                    header('Location: ' . $this->url . 'listar');
                }
            } catch (\Exception $e) {
                    // $e->getMessage();
                    $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
                    $plantilla-> display(array('message' => "Error, el usuario no se pudo eliminar."));
            }

        }

        public function enableUsers(){
            if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
                #validar que llegaron
                foreach ($_POST as $key => $value) {
                     try {
                        $user = $GLOBALS['em']->getRepository('Src\Entity\User\User')->find($value);
                        $user->setEnabled(True);
                        $GLOBALS['em']->persist($user);
                        $GLOBALS['em']->flush();
                         
                     } catch (Exception $e) {
                         
                     }

                }
                header('Location: ' . $this->url . 'listar');
            }else{
                /* Paginacion -- que elementos mostrar */
                $page=0;
                $firstResult=0;
                $maxResultsQuery= ($GLOBALS['em']->getRepository('Src\Entity\Configuration\Configuration')->find(1));
                $maxResults = $maxResultsQuery->getNumberOfItems();
                
                if (isset($_GET['page'])) {
                    $page=$_GET['page'];
                    $firstResult=$page * $maxResults;
                }
                /* Paginacion -- que elementos mostrar */
                /* Paginacion -- calcular numero de paginas */
              
                $numberOfItems= count($GLOBALS['em']->getRepository('Src\Entity\User\User')-> findByDisabled());

                $numberOfPages= ceil($numberOfItems / $maxResults);

                /* Paginacion -- calcular numero de paginas */
                $users = $GLOBALS['em']->getRepository('Src\Entity\User\User')->findByDisabledPaged($firstResult, $maxResults);
                $plantilla = $GLOBALS['twig']-> loadTemplate('user/disabledList.html.twig');
                $plantilla-> display(array('users' => $users, 'actualPage' => $page, 'numberOfPages' => $numberOfPages, 'url'=>$this->url));
                #enviarlos a la vista
            }
        } 
	}
