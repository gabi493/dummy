<?php
namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Post;

class PostModel
{    
    private $em;
    private $container;
    
    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;        
        $this->container = $container;     
    }
    
    public function getAllPosts()
    {        
        return $this->em->getRepository('AppBundle:Post')->findBy(
            array('fk_postId' => null),
            array('date' => 'DESC')
        );        
    }
    
    public function getPosts($userid = 0)
    {
        // sanitize
        if (empty($userid)) {
            return array();
        }
        
        return $this->em->getRepository('AppBundle:Post')->findBy(
            array(
                "fk_userId" => $userid,
                "fk_postId" => null                
            ),
            array('date' => 'DESC')
        );        
    }
    
    public function getComments($postid = 0)
    {
        // sanitize
        if (empty($postid)) {
            return array();
        }
        
        return $this->em->getRepository('AppBundle:Post')->findBy(
            array("fk_postId" => $postid),
            array('date' => 'DESC')
        );
    }
    
    public function createComment($userid = 0, $parentid = 0, $titulo = "", $comentario = "")
    {
        // sanitize
        if (empty($userid) || empty($parentid) || empty($titulo) || empty($comentario)) {  
            // exception
            return false;
        }
        
        // get the user
        $usuario = $this->em->getRepository('AppBundle:User')->findOneBy(array(
            "id" => $userid
        ));
        if (empty($usuario)) {
            // exception            
            return false;
        }
        
        // get the parent post
        $parentpost = $this->em->getRepository('AppBundle:Post')->findOneBy(array(
            "id" => $parentid
        ));
        if (empty($parentpost)) {
            // exception            
            return false;
        }
                
        $post = new Post();
        $post->setTitulo($titulo);
        $post->setDescription($comentario);
        $post->setFkPostId($parentpost);
        $post->setFkUserId($usuario);
        $post->setDate(time());                        
        
        // a la bd!
        $this->em->persist($post);
        $this->em->flush();
        
        return true;        
    }
    
    public function deleteComment($userid = 0, $parentid = 0, $postid = 0)
    {
        // sanitize
        if (empty($userid) || empty($parentid) || empty($postid)) {  
            // exception
            return false;
        }
                
        // get the post
        $post = $this->em->getRepository('AppBundle:Post')->findOneBy(array(                    
            "id" => $postid,
            "fk_userId" => $userid,
            "fk_postId" => $parentid,
        ));
        if (empty($post)) {
            // exception            
            return false;
        }
                                        
        // actualizamos la bd
        $this->em->remove($post);
        $this->em->flush();
        
        return true;        
    }
    
    
            
}
