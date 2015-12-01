<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @ORM\Entity()
 */
class Module
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
     * @NotNull()
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course")
     * @var Course
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Chapter", mappedBy="module")
     * @var Chapter[]|ArrayCollection
     */
    private $chapters;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     * @return $this
     */
    public function setCourse(Course $course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Chapter[]|ArrayCollection
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * @param Chapter $chapter
     * @return $this
     */
    public function addChapter(Chapter $chapter)
    {
        $this->chapters[] = $chapter;

        return $this;
    }

    /**
     * @param Chapter $chapter
     */
    public function removeChapter(Chapter $chapter)
    {
        $this->chapters->removeElement($chapter);
    }
}