<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity()
 */
class VariantQuestion
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
    private $correctChoices;

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
    public function getCorrectChoices()
    {
        return $this->correctChoices;
    }

    /**
     * @param int $correctChoices
     * @return $this
     */
    public function setCorrectChoices($correctChoices)
    {
        $this->correctChoices = $correctChoices;

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