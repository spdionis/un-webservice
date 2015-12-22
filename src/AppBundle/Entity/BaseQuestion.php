<?php


namespace AppBundle\Entity;


use AuthBundle\Entity\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @Entity()
 */
class BaseQuestion
{
    const TEXT_AREA = 'text_area';
    const CHOICE = 'choice';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @NotNull()
     * @Column(type="text")
     *
     * @var string
     */
    private $content;

    /**
     * @NotNull()
     * @Column(type="boolean")
     *
     * @var bool
     */
    private $enabled = false;

    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\Topic")
     *
     * @var Topic
     */
    private $topic;

    /**
     * @ManyToOne(targetEntity="AuthBundle\Entity\User")
     *
     * @var User
     */
    private $createdBy;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $type;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param Topic $topic
     * @return $this
     */
    public function setTopic(Topic $topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return $this
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
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
        if (!in_array($type, [self::TEXT_AREA, self::CHOICE], true)) {
            throw new \InvalidArgumentException("Unknown type '$type'.");
        }

        $this->type = $type;

        return $this;
    }

    public static function getTypes()
    {
        return [self::TEXT_AREA, self::CHOICE];
    }

}