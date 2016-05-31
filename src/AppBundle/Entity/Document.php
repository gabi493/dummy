<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 */
class Document
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $originalName;

    /**
     * @var string
     */
    private $name;

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
     * Set originalName
     *
     * @param string $originalName
     * @return Document
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string 
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set fk_postId
     *
     * @param \AppBundle\Entity\Post $fkPostId
     * @return Document
     */
    public function setFkPostId(\AppBundle\Entity\Post $fkPostId)
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
