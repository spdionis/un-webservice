<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class BaseAnswer
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
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BaseQuestion")
     *
     * @var BaseQuestion
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TestInstance")
     *
     * @var TestInstance
     */
    private $test;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        if (!in_array($type, [BaseQuestion::CHOICE, BaseQuestion::TEXT_AREA], true)) {
            throw new \InvalidArgumentException("Unknown type '$type'.");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return BaseQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param BaseQuestion $question
     * @return $this
     */
    public function setQuestion(BaseQuestion $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return TestInstance
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param TestInstance $test
     * @return $this
     */
    public function setTest(TestInstance $test)
    {
        $this->test = $test;

        return $this;
    }

}