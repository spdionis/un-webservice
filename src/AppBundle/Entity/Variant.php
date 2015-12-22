<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity()
 */
class Variant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", length=250)
     *
     * @var string
     */
    private $body;

    /**
     * @Column(type="boolean")
     *
     * @var bool
     */
    private $correct;

    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\VariantQuestion")
     *
     * @var VariantQuestion
     */
    private $question;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->correct;
    }

    /**
     * @param boolean $correct
     * @return $this
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * @return VariantQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param VariantQuestion $question
     * @return $this
     */
    public function setQuestion(VariantQuestion $question)
    {
        $this->question = $question;

        return $this;
    }


}