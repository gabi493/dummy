<?php
namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\User;

class SessionModel
{    
    private $em;
    private $container;
    
    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        // iniciamos el motor de sesión solo si no está arrancado
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->em = $em;        
        $this->container = $container;
    }
    
    public function isLogged()
    {        
        return (isset($_SESSION['logado']) && ($_SESSION['logado'] === true));
    }
    
    public function createSession($userdata = array())
    {     
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $userdata;
        
        return true;
    }
    
    public function destroySession()
    {
        unset($_SESSION['logado']);
        unset($_SESSION['usuario']);        
        return true;
    }        
}
