<?php


namespace AppBundle\Entity;


use AuthBundle\Entity\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity()
 * @HasLifecycleCallbacks()
 */
class Test
{
    const TYPE_DEMO = 'demo';
    const TYPE_LIVE = 'live';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $type = self::TYPE_DEMO;

    /**
     * @Column(type="datetime")
     *
     * @var \DateTime
     */
    private $timeout;

    /**
     * @Column(type="datetime")
     *
     * @var \DateTime
     */
    private $created;

    /**
     * @ManyToOne(targetEntity="AuthBundle\Entity\User")
     * @JoinColumn(nullable=false)
     *
     * @var User
     */
    private $createdBy;

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
        if (!in_array($type, [self::TYPE_DEMO, self::TYPE_LIVE], true)) {
            throw new \InvalidArgumentException("Unknown type '$type'.");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param \DateTime $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

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
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @PrePersist()
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime;
    }
}