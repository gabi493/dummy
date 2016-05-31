<?php
namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RolModel
{
    private $em;
    private $container;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getRols()
    {
        return $this->em->getRepository('AppBundle:Rol')->findAll();
    }

    public function getRolById($id = "")
    {
        // sanitize
        if (empty($id)) {
            return null;
        }

        return $this->em->getRepository('AppBundle:Rol')->findOneBy(array("id" => $id));
    }

}
