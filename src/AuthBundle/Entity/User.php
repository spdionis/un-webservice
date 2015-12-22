<?php


namespace AuthBundle\Entity;

use AppBundle\Entity\Course;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @Entity(repositoryClass="AuthBundle\Entity\Repository\UserRepository")
 * @Table("users")
 */
class User implements UserInterface
{
    /**
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @NotNull()
     * @Column(type="string")
     *
     * @var string
     */
    private $username;

    /**
     * @NotNull()
     * @Length(min="8")
     * @Column(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * @Column(type="simple_array")
     *
     * @var array
     */
    private $roles = ['ROLE_USER'];

    /**
     * @ManyToMany(targetEntity="AppBundle\Entity\Course")
     *
     * @var Course[]|ArrayCollection
     */
    private $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function getCourses()
    {
        return $this->courses;
    }

    public function addCourse(Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);
    }

}