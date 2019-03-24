<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="students")
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", nullable=false)
     */
    protected $first_name = null;

    /**
     * @ORM\Column(name="last_name", nullable=false)
     */
    protected $last_name = null;

    /**
     * @ORM\Column(name="group_num", type="integer", nullable=false)
     */
    protected $group = null;

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Classes")
     * @ORM\JoinTable(name="student_to_classes",
     *      joinColumns={@ORM\JoinColumn(name="student_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="classes_id", referencedColumnName="id")}
     *      )
     */
    protected $classes = null;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $first_name
     * @return Student
     */
    public function setFirstName($first_name)
    {
        $this->firstName = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $last_name
     * @return Student
     */
    public function setLastName($last_name)
    {
        $this->lastName = $last_name;
        return $this;
    }

    /**
     * @return array
     */
    public function getClasses()
    {
        return $this->classes->getValues();
    }

    /**
     * @param Classes $classes
     * @return Student
     */
    public function addClasses(Classes $classes)
    {
        $this->classes->add($classes);
        return $this;
    }

    /**
     * @param Classes $classes
     * @return bool
     */
    public function classesIsAdded(Classes $classes)
    {
        return $this->classes->contains($classes);
    }

    /**
     * @param Classes $classes
     * @return Student
     */
    public function removeClasses(Classes $classes)
    {
        $this->classes->removeElement($classes);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }
}