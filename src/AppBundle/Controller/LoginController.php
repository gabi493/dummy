<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LoginController
{
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