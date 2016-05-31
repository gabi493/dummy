<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{  
    /**
     * / :: indexAction
     */
    public function indexAction(Request $request)
    {
        // comprobamos si estamos logados con el servicio de sesión
        if (!$this->container->get('model.session')->isLogged()) {
            // nos vamos a la zona de login
            return $this->forward('AppBundle:Login:index');            
        }
        // entramos en la aplicación
        return $this->forward('AppBundle:Main:index');
    }
}

/*
 * $.ajax({
               type: "POST",
               url: '/lanzarinformebehat',
               success: function(html) {
                    //document.location.href = '/leerelfichero';
                    $.ajax({
                        type: "POST",
                        url: '/leerelfichero',
                        success: function(_html) {
                             // mostrarl el contenido del fichero que viene en _html
                        }
                  });
               }
         });
 *
 *
 * */
