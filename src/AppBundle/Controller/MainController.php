<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{  
    /**
     * /main :: indexAction
     */
    public function indexAction(Request $request)
    {
        // comprobamos si estamos logados con el servicio de sesión
        if (!$this->container->get('model.session')->isLogged()) {
            // nos vamos a la aplicación
            return $this->redirect('AppBundle:Login:index');            
        } 
        
        // cogemos los posts de la aplicación
        $_posts = $this->container->get('model.post')->getAllPosts();     
        
        // procesamos los posts
        $posts = array();
        foreach($_posts as $_post) {
            $post = array();
            // procesamos los comentarios
            $comments = array();
            $_comments = $this->container->get('model.post')->getComments($_post->getId());                        
            foreach($_comments as $_comment) {
                $comment = array();
                
                $comment['id'] = $_comment->getId();
                $comment['autorID'] = $_comment->getFkUserId()->getId();
                $comment['autor'] = $_comment->getFkUserId()->getUsername();
                $comment['date'] = date('d/m/Y H:i:s', $_comment->getDate());
                $comment['title'] = $_comment->getTitulo();
                $comment['description'] = $_comment->getDescription();
                
                $comments[] = $comment;                
            }
            
            $post['id'] = $_post->getId();
            $post['autorID'] = $_post->getFkUserId()->getId();
            $post['autor'] = $_post->getFkUserId()->getUsername();
            $post['date'] = date('d/m/Y H:i:s', $_post->getDate());
            $post['title'] = $_post->getTitulo();
            $post['description'] = $_post->getDescription();
            $post['comments'] = $comments;
            
            $posts[] = $post;
        }
        
        return $this->render('AppBundle:main:index.html.twig', array(
            "usuario" => $_SESSION['usuario'],
            "posts" => $posts
        ));
    }
    
    /**
     * 
     */
    public function newCommentAction(Request $request)
    {
        // comprobamos si estamos logados con el servicio de sesión
        if (!$this->container->get('model.session')->isLogged()) {
            // nos vamos a la aplicación
            return $this->redirect('AppBundle:Login:index');            
        }

        // sanitize parameters
        $parentid = $request->get("parentid");
        $titulo = $request->get("titulo");
        $comentario = $request->get("comentario");

        if (empty($parentid)) {
            die ('error: 1');
        }
        if (empty($titulo)) {
            die('error: 2');
        }
        if (empty($comentario)) {
            die('error: 3');
        }

        // creamos el post
        if (!$this->container->get('model.post')->createComment($_SESSION['usuario']['id'], $parentid, $titulo, $comentario)) {
            // excepcion
            die ('error: 4');
        }         
        
        // todo ok -> recuperamos los comments del post que nos marca "parentid"        
        $comments = array();
        $_comments = $this->container->get('model.post')->getComments($parentid);                        
        foreach($_comments as $_comment) {
            $comment = array();

            $comment['id'] = $_comment->getId();
            $comment['autorID'] = $_comment->getFkUserId()->getId();
            $comment['autor'] = $_comment->getFkUserId()->getUsername();
            $comment['date'] = date('d/m/Y H:i:s', $_comment->getDate());
            $comment['title'] = $_comment->getTitulo();
            $comment['description'] = $_comment->getDescription();

            $comments[] = $comment;                
        } 
        
        // devolvemos listado actualizado de comentarios
        
        return $this->render('AppBundle:main:comments.html.twig', array(  
            "usuario" => $_SESSION['usuario'],
            "post" => array(
                "comments" => $comments
            )
        ));        
    }
    
    /**
     * 
     */
    public function deleteCommentAction(Request $request)
    {
        // comprobamos si estamos logados con el servicio de sesión
        if (!$this->container->get('model.session')->isLogged()) {
            // nos vamos a la aplicación
            return $this->redirect('AppBundle:Login:index');            
        }

        // sanitize parameters
        $commentid = trim($request->get("postid"));
        $parentid = trim($request->get("parentid"));

        if (empty($commentid)) {
            die ('error: 1');
        }
        if (empty($parentid)) {
            die('error: 2');
        }

        // creamos el post
        if (!$this->container->get('model.post')->deleteComment($_SESSION['usuario']['id'], $parentid, $commentid)) {
            // excepcion
            die('error: 3');
        }         
        
        // todo ok -> recuperamos los comments del post que nos marca "parentid"        
        $comments = array();
        $_comments = $this->container->get('model.post')->getComments($parentid);                        
        foreach($_comments as $_comment) {
            $comment = array();

            $comment['id'] = $_comment->getId();
            $comment['autorID'] = $_comment->getFkUserId()->getId();
            $comment['autor'] = $_comment->getFkUserId()->getUsername();
            $comment['date'] = date('d/m/Y H:i:s', $_comment->getDate());
            $comment['title'] = $_comment->getTitulo();
            $comment['description'] = $_comment->getDescription();

            $comments[] = $comment;                
        } 
        
        // devolvemos listado actualizado de comentarios
        
        return $this->render('AppBundle:main:comments.html.twig', array(  
            "usuario" => $_SESSION['usuario'],
            "post" => array(
                "comments" => $comments
            )
        ));        
    }

    /**
     *
     */
    public function aboutusAction(Request $request)
    {
        // comprobamos si estamos logados con el servicio de sesión
        if (!$this->container->get('model.session')->isLogged()) {
            // nos vamos a la aplicación
            return $this->redirect('AppBundle:Login:index');
        }

        return $this->render('AppBundle:main:aboutus.html.twig', array(
            "selectedSection" => "aboutus",
            "usuario" => $_SESSION['usuario']
        ));

    }
    
}


