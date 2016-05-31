<?php
namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;


class UserModel
{    
    private $em;
    private $container;
    
    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;        
        $this->container = $container;     
    }   
    
    public function login($username = "", $password = "")
    {
        // sanitize
        if (empty($username) || empty($password)) {
            return null;
        }
        
        //:: NICETOHAVE: mas validacion de los campos                
        
        return $this->em->getRepository('AppBundle:User')->findOneBy(array(
            "username" => $username,
            "password" => $password
        ));
    }

    public function signup($mail = "", $username = "", $password = "", $enterprise = null, $rol = null)
    {
        // sanitize
        if (empty($mail) || empty($username) || empty($password)) {
            return null;
        }

        try {
            $newUser = new User();
            $newUser->setUsername($username);
            $newUser->setPassword($password);
            $newUser->setFkRolId($rol);
            $newUser->setMail($mail);
            $newUser->setFkEnterpriseId($enterprise);

            $this->em->persist($newUser);
            $this->em->flush();
        }
        catch (\Exception $e) {
            throw new Exception($e);
        }


        return true;
    }
}
