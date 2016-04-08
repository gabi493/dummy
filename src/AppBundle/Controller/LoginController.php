<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LoginController
{
    public function indexAction() {
        /*return new Response(
            http_redirect("http://localhost:8000/login")
        );*/
        $names = array("Raúl", "Jose", "Gabriel", "Araceli", "Aureli");
        $number = rand(0, 100)%5;

        return new Response(
            '<html><body>Lucky team member: '.$names[$number].'</body></html>'
        );
//        return $this->redirectToRoute('login');
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
}