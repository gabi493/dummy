<?php
namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EnterpriseModel
{
    private $em;
    private $container;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getEnterprises()
    {
        return $this->em->getRepository('AppBundle:Enterprise')->findAll();
    }

    public function getEnterpriseById($id = "")
    {
        // sanitize
        if (empty($id)) {
            return null;
        }

        return $this->em->getRepository('AppBundle:Enterprise')->findOneBy(array("id" => $id));
    }

}
