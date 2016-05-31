<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * /login :: indexAction     
     */
    public function indexAction(Request $request)
    {
        // comprobamos si estamos logados con el servicio de sesión
        if ($this->container->get('model.session')->isLogged()) {
            // nos vamos a la aplicación
            return $this->redirect('AppBundle:Main:index');            
        }
        
        // render al formulario de login
        return $this->render('AppBundle:login:login.html.twig');
    }   
    
    /**
     * /login.do :: loginDoAction
     */
    public function loginDoAction(Request $request)
    {
        // recogemos los parametros
        $username = $request->get("username");
        $password = $request->get("password");                
        
        // sanitize
        // TODO
        
        // login
        $usuario = $this->container->get('model.user')->login($username, $password);   


        if (empty($usuario)) {                
            // redirigimos al error
            return $this->redirect($this->generateUrl('loginError', array(
                'errorcode' => 1
            )));            
            
        } else {
            // recuperamos los datos que nos interesan y los guardamos en sesión
            $userdata = array(
                "id" => $usuario->getId(),
                "name" => $usuario->getUsername(),
                "mail" => $usuario->getMail(),
                "enterprise" => array(
                    "id" => $usuario->getFkEnterpriseId()->getId(),
                    "name" => $usuario->getFkEnterpriseId()->getName(),
                    "address" => $usuario->getFkEnterpriseId()->getAddress(),
                    "city" => $usuario->getFkEnterpriseId()->getCity(),
                    "postalcode" => $usuario->getFkEnterpriseId()->getPostalCode()
                )
            );
            $this->container->get('model.session')->createSession($userdata);                        
            
            // redigirimos al contenido
            return $this->redirect($this->generateUrl('aboutus'));
        }
    }
    
    /**
     * /login.error/{errorcode} :: loginErrorAction     
     */
    public function loginErrorAction(Request $request, $errorcode = 0)
    {
        // error?
        switch($errorcode) {
            case 0: // ninguno
                $errormsg = "";
                break;
            case 1: // datos incorrectos
                $errormsg = "Incorrect username or password";
                break;
        }

        // render al formulario de login
        return $this->render('AppBundle:login:login.html.twig', array(
            "error" => array(
                "code" => $errorcode,
                "message" => $errormsg
            )
        ));
    }
    
    /**
     * /logout :: logoutAction
     */
    public function logoutAction(Request $request)
    {
        // borramos la sesión
        $this->container->get('model.session')->destroySession();
        // nos vamos a la zona de login
        return $this->redirect($this->generateUrl('root'));        
    }    
}