<?php

namespace SiteBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SiteBlogBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="SiteBlogBundle\Entity\Advert", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set advert
     *
     * @param \SiteBlogBundle\Entity\Advert $advert
     *
     * @return Application
     */
    public function setAdvert(Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \SiteBlogBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * @ORM\PrePersist
     */
    public function increase()
    {
        $this->getAdvert()->increaseApplication();
    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $this->getAdvert()->decreaseApplication();
    }
}
