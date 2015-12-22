<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToOne;


/**
 * @Entity()
 */
class TextAreaQuestion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var
     */
    private $id;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    private $textLimit;

    /**
     * @OneToOne(targetEntity="AppBundle\Entity\BaseQuestion")
     *
     * @var BaseQuestion
     */
    private $baseQuestion;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTextLimit()
    {
        return $this->textLimit;
    }

    /**
     * @param int $textLimit
     * @return $this
     */
    public function setTextLimit($textLimit)
    {
        $this->textLimit = $textLimit;

        return $this;
    }

    /**
     * @return BaseQuestion
     */
    public function getBaseQuestion()
    {
        return $this->baseQuestion;
    }

    /**
     * @param BaseQuestion $baseQuestion
     * @return $this
     */
    public function setBaseQuestion(BaseQuestion $baseQuestion)
    {
        $this->baseQuestion = $baseQuestion;

        return $this;
    }

}