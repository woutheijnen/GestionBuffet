<?php namespace Src\Controller;

use Src\Entity\Configuration;
use Src\Entity\User;

class ConfigurationController {
    private $url;

    public function __construct(){
        $this->url = $_SESSION['base_path'];
    }
    public function index() {

    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $config = new Configuration\Configuration();
            if ($_POST['id']) {
                $config = $GLOBALS['em']->getRepository('Src\Entity\Configuration\Configuration')->find($_POST['id']);
            }
            /*Validaciones*/
            if (isset($_POST['title']) &&
                isset($_POST['number-of-items']) &&
                isset($_POST['enabled-site']) &&
                isset($_POST['disabling-message'])) {
                    $config-> setTitle($_POST['title']);
                    $config-> setNumberOfItems($_POST['number-of-items']);
                    $config-> setEnabledSite($_POST['enabled-site']);
                    $config-> setDisablingMessage($_POST['disabling-message']);
                    $GLOBALS['em']->persist($config);
                    $GLOBALS['em']->flush();
                    header('Location: ' . $this->url . 'index');
            }else{
                $plantilla = $GLOBALS['twig']-> loadTemplate('messagesPage.html.twig');
                $plantilla-> display(array('message' => "Error, datos incorrectos"));
            }
    	}else{
    		$configuration = $GLOBALS['em']->getRepository('Src\Entity\Configuration\Configuration')->find(1);
        	$plantilla = $GLOBALS['twig']-> loadTemplate('configuration.html');
        	$plantilla-> display(array('config' => $configuration,'url'=>$this->url));
    	}
    }

    public function firstCharge(){
       $config = $GLOBALS['em']->getRepository('Src\Entity\configuration\Configuration')->findAll();
       $users = $GLOBALS['em']->getRepository('Src\Entity\User\User')->findAll();

       if (count($config) == 0 and (count($users) == 0)) {
         $config = new Configuration\Configuration();
         $config->setNumberOfItems(1);
         $config->setEnabledSite(True);
         $config->setTitle('');
         $config->setDisablingMessage('');
         $GLOBALS['em']->persist($config);

         $role = new User\Role();
         $role->setName('ADMIN');
         $GLOBALS['em']->persist($role);

         $user = new User\User();
         $user->setRole($role);
         $user->setUsername('admin');
         $pass= md5('admin');//HASH
         $user->setPassword($pass);
         $user->setName('admin');
         $user->setLastName('');
         $user->setDocumentType('');
         $user->setDocument('');
         $user->setEmail('');
         $user->setTelephone('');
         $user->setEnabled(1);
         $GLOBALS['em']->persist($user);
         $GLOBALS['em']->flush();

       }else {
         throw new \Exception("Error Database", 1);
       }
    }
}
