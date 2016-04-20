<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;






class LoginController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('AppBundle::login/form.html.twig', array(
        ));
    }

    public function loginAction(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        /*return new JsonResponse(json_encode(array(
            array
            (
                'username'=> $username,
                'password'=> $password
            ),
            array
            (
                'errorCode'=> '1',
                'errorMessage'=> 'Username not registered in the system'
            )

        )));*/

        return $this->render('AppBundle::login/form.html.twig', array
        (
            'error'=> array(
                'code'=> '1',
                'message'=> 'Username not registered in the system'
            )
        ));
    }

    public function testAction(Request $request)
    {
        $cmd = 'cd /Applications/MAMP/htdocs/dummy; bin/behat';
        //$cmd2 = 'ls -la';
        $salida = shell_exec($cmd);
        if (null === $salida) {
            throw new \Exception('The element $salida is not found');
        }

        return $this->render('AppBundle::test/loginForm.html.twig', array
        (
            'output'=> array(
                'command'=> $cmd,
                'salida'=> $salida
            )
        ));
    }

}