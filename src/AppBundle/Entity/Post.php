<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 */
class Post
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $date;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \AppBundle\Entity\User
     */
    private $fk_userId;

    /**
     * @var \AppBundle\Entity\Post
     */
    private $fk_postId;


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
     * Set date
     *
     * @param integer $date
     * @return Post
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return integer 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Post
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set fk_userId
     *
     * @param \AppBundle\Entity\User $fkUserId
     * @return Post
     */
    public function setFkUserId(\AppBundle\Entity\User $fkUserId)
    {
        $this->fk_userId = $fkUserId;

        return $this;
    }

    /**
     * Get fk_userId
     *
     * @return \AppBundle\Entity\User 
     */
    public function getFkUserId()
    {
        return $this->fk_userId;
    }

    /**
     * Set fk_postId
     *
     * @param \AppBundle\Entity\Post $fkPostId
     * @return Post
     */
    public function setFkPostId(\AppBundle\Entity\Post $fkPostId = null)
    {
        $this->fk_postId = $fkPostId;

        return $this;
    }

    /**
     * Get fk_postId
     *
     * @return \AppBundle\Entity\Post 
     */
    public function getFkPostId()
    {
        return $this->fk_postId;
    }
}
