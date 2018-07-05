<?php
namespace Src\Controller;
use Src\Entity\User;
use Src\Entity\Configuration;

require_once "libraries/Password.php";

class MainController {

    public function index() {
      $config = $GLOBALS['em']->getRepository('Src\Entity\Configuration\Configuration')->find(1);

      $data = array('configuration' => $config);
      $plantilla = $GLOBALS['twig']->loadTemplate('index.html.twig');
      $plantilla->display($data);
    }

    public function login(){
      $data = array();
      if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $user = $GLOBALS['em']->getRepository('Src\Entity\User\User')->findOneByUsername($_POST['username']);
        if ($user != null){
          if (\Library\password_verify($user->getPassword(), md5($_POST['password']))) {
            if ($user->getEnabled() == true ) {
              $_SESSION['loggedin'] = true;
              $_SESSION['username'] = $user->getUsername();
              $_SESSION['role'] = $user->getRole()->getName();
              $_SESSION['start'] = time();
              $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
              header('Location: '.constant('HOME_'.$_SESSION['role']));
            }else{
              $data['msg']= "Usuario no habilitado";
            }
          } else {
            $data['msg']= "Usuario o contraseña incorrecta";
          }
        }else {
          $data['msg']= "Usuario o contraseña incorrecta";
        }
      }
  $plantilla = $GLOBALS['twig']->loadTemplate('login.html.twig');
  $plantilla-> display($data);
  }

  public function logout(){
    session_destroy();
    header('Location: '.constant('HOME_ANON'));
//    header('Location: /');
  }


  public function addUser(){
    if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
      $user = new User\User();

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
          $user->setEnabled(0);//usuario deshabilitado hasta que lo habilite un admin

          if (isset($_POST['location'])) {
            $location = $GLOBALS['em']->getRepository('Src\Entity\User\Location')->find($_POST['location']);
            $user->setLocation($location);
            if (isset($_POST['role'])) {
              $role = $GLOBALS['em']->getRepository('Src\Entity\User\Role')->find($_POST['role']);
              $user->setRole($role);

              $GLOBALS['em']->persist($user);
              $GLOBALS['em']->flush();
              header('Location: ' . $this->url . 'index');
            }else{
            $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
            $plantilla-> display(array('message' => "Error, rol inexistente."));
            }

          }else{
            $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
           $plantilla-> display(array('message' => "Error, ubicaci&oacute;n inexistente."));
          }

        }else{
         $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
         $plantilla-> display(array('message' => "Error, las contraseñas no son iguales."));
        }
      }else{
        $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
        $plantilla-> display(array('message' => "Error, datos incorrectos"));
      }
    }else{
      $roles = $GLOBALS['em']->getRepository('Src\Entity\User\Role')->findOneByName("EXTERNO");
      $locations = $GLOBALS['em']->getRepository('Src\Entity\User\Location')->findAll();
      $plantilla = $GLOBALS['twig']-> loadTemplate('add-user.html.twig');
      $data = array(
        'role' => $roles,
        'locations' => $locations,
      );
      $plantilla-> display($data);
    }
  }

}
