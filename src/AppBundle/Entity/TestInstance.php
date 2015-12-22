<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AuthBundle\Entity\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @Entity()
 */
class TestInstance
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
     * @ManyToOne(targetEntity="AppBundle\Entity\Test")
     *
     * @var Test
     */
    private $test;

    /**
     * @ManyToOne(targetEntity="AuthBundle\Entity\User")
     *
     * @var User
     */
    private $user;

    /**
     * @Column(type="datetime")
     *
     * @var \DateTime
     */
    private $started;

    /**
     * @Column(type="datetime")
     *
     * @var \DateTime
     */
    private $ended;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param Test $test
     * @return $this
     */
    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @param \DateTime $started
     * @return $this
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * @param \DateTime $ended
     * @return $this
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

}