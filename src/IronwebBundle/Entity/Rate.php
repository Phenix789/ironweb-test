<?php

namespace IronwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints;

/**
 * Class Rate
 *
 * @package IronwebBundle\Entity
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="IronwebBundle\Entity\RateRepository")
 */
class Rate
{

    const RATE_MIN = 0;
    const RATE_MAX = 5;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"list", "show"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255)
     *
     * @Constraints\NotNull()
     * @Constraints\NotBlank()
     * @Constraints\Length(max="255")
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"list", "show"})
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="smallint")
     *
     * @Constraints\Range(min=0, max=5)
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"list", "show"})
     */
    private $rate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"list", "show"})
     */
    private $date;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param int $rate
     *
     * @return $this
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     *
     * @return $this
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

}
