<?php
// src/AppBundle/Controller/SignupController.php
namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SignupController extends Controller
{
    /**
     * /signup :: indexAction
     */
    public function indexAction(Request $request)
    {
        // comprobamos si estamos logados con el servicio de sesión
        if ($this->container->get('model.session')->isLogged()) {
            // nos vamos a la aplicación
            return $this->redirect('AppBundle:Main:index');
        }

        $enterprises = $this->container->get('model.enterprise')->getEnterprises();
        $rols = $this->container->get('model.rol')->getRols();

        // render al formulario de signup
        return $this->render('AppBundle:signup:signup.html.twig', array(
            "enterprises" => $enterprises,
            "rols" => $rols
        ));
    }

    /**
     * /signup.do :: signupDoAction
     */
    public function signupDoAction(Request $request)
    {
        // recogemos los parametros
        $mail = $request->get("mail");
        $username = $request->get("username");
        $password = $request->get("password");
        $idE = $request->get("enterprises");
        $idR = $request->get("rols");

        // sanitize
        // TODO

        // signup
        $enterprise = $this->container->get('model.enterprise')->getEnterpriseById($idE);
        $rol = $this->container->get('model.rol')->getRolById($idR);

//        print_r($username);
//        print_r(strlen($username));
//        print_r($idR);
//        die("He muerto");

//        if (strpos($a, 'are') !== false)

        if (empty($mail) || empty($username) || empty($password)) {
            // redirigimos al error
            return $this->redirect($this->generateUrl('signupError', array(
                'errorcode' => 1
            )));
        } else if (strlen($username) <= 5) {
            return $this->redirect($this->generateUrl('signupError', array(
                'errorcode' => 2
            )));
        } else if (strlen($password) <= 5) {
            return $this->redirect($this->generateUrl('signupError', array(
                'errorcode' => 3
            )));
        } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return $this->redirect($this->generateUrl('signupError', array(
                'errorcode' => 4
            )));
        } else {
            // signup
            $this->container->get('model.user')->signup($mail, $username, $password, $enterprise, $rol);

            // redigirimos al contenido
//            return $this->redirect('login');
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
    }

    /**
     * /signup.error/{errorcode} :: signupErrorAction
     */
    public function signupErrorAction(Request $request, $errorcode = 0)
    {
        // error?
        switch($errorcode) {
            case 0: // ninguno
                $errormsg = "";
                break;
            case 1: // datos incorrectos
                $errormsg = "Fill in all the fields";
                break;
            case 2: // datos incorrectos
                $errormsg = "Username must be at least 6 characters long";
                break;
            case 3: // datos incorrectos
                $errormsg = "Password must be at least 6 characters long";
                break;
            case 4: // datos incorrectos
                $errormsg = "Invalid e-mail format";
                break;
        }

        // render al formulario de signup --> la plantilla requiere rol y enterprise
        $enterprises = $this->container->get('model.enterprise')->getEnterprises();
        $rols = $this->container->get('model.rol')->getRols();

        return $this->render('AppBundle:signup:signup.html.twig', array(
            "enterprises" => $enterprises,
            "rols" => $rols,
            "error" => array(
                "code" => $errorcode,
                "message" => $errormsg
            )
        ));
    }


}