<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \AppBundle\Entity\Enterprise
     */
    private $fk_enterpriseId;

    /**
     * @var \AppBundle\Entity\Rol
     */
    private $fk_rolId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set fk_enterpriseId
     *
     * @param \AppBundle\Entity\Enterprise $fkEnterpriseId
     * @return User
     */
    public function setFkEnterpriseId(\AppBundle\Entity\Enterprise $fkEnterpriseId)
    {
        $this->fk_enterpriseId = $fkEnterpriseId;

        return $this;
    }

    /**
     * Get fk_enterpriseId
     *
     * @return \AppBundle\Entity\Enterprise 
     */
    public function getFkEnterpriseId()
    {
        return $this->fk_enterpriseId;
    }

    /**
     * Set fk_rolId
     *
     * @param \AppBundle\Entity\Rol $fkRolId
     * @return User
     */
    public function setFkRolId(\AppBundle\Entity\Rol $fkRolId)
    {
        $this->fk_rolId = $fkRolId;

        return $this;
    }

    /**
     * Get fk_rolId
     *
     * @return \AppBundle\Entity\Rol 
     */
    public function getFkRolId()
    {
        return $this->fk_rolId;
    }
}
