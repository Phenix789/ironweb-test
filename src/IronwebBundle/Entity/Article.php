<?php

namespace IronwebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints;

/**
 * Class Article
 *
 * @package IronwebBundle\Entity
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="IronwebBundle\Entity\ArticleRepository")
 */
class Article
{

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
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Constraints\NotNull()
     * @Constraints\NotBlank()
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"list", "show"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     *
     * @Serializer\Expose()
     * @Serializer\Groups({"show"})
     */
    private $content;

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
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     * @Serializer\Groups({"show"})
     */
    private $comments;

    /**
     * @var Rate[]
     *
     * @ORM\OneToMany(targetEntity="Rate", mappedBy="article")
     * @Serializer\Groups({"show"})
     */
    private $rates;

    /**
     * @return float
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @Serializer\VirtualProperty()
     * @Serializer\Groups({"list"})
     */
    public function getRate()
    {
        $rates = $this->getRates();
        $count = count($rates);
        if ($count > 0) {
            $value = 0;
            foreach ($rates as $rate) {
                $value += $rate->getRate();
            }

            return round($value / $count, 2);
        }

        return 0;
    }

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

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
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     *
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return Rate[]
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * @param Rate[] $rates
     *
     * @return $this
     */
    public function setRates($rates)
    {
        $this->rates = $rates;

        return $this;
    }

}
