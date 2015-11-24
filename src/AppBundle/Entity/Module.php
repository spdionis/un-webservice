<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Discipline")
     * @var Discipline
     */
    private $discipline;

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
     * @return Discipline
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * @param Discipline $discipline
     * @return $this
     */
    public function setDiscipline(Discipline $discipline)
    {
        $this->discipline = $discipline;

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