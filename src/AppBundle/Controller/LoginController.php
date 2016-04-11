<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function indexAction() {
        /*return new Response(
            http_redirect("http://localhost:8000/login")
        );*/

        /*$number = rand(0, 6);

        if ($number % 2) {*/
            //return $this->redirect($this->generateUrl('login'));
            return $this->render(
                'login/form.html.twig'
            );
        /*}
        else {
            return $this->redirect($this->generateUrl('xlogin'));
        }*/
    }
    public function nameAction()
    {
        $names = array("Raúl", "Jose", "Gabriel", "Araceli", "Aureli");
        $number = rand(0, 100)%5;

        return new Response(
            '<html><body>Lucky team member: '.$names[$number].'</body></html>'
        );
    }

    public function errorAction()
        {
            return new Response(
                '<html><body>Error (we are talking about your life)</body></html>'
            );
        }
    public function xloginAction()
    {
        return new Response(
            '<html><body>_.-·xxXxx·-._</body></html>'
        );
    }
}