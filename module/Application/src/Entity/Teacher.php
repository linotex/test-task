<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="teachers")
 */
class Teacher
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
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Job", inversedBy="jobs", cascade={"persist"})
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id", onDelete="NULL")
     */
    protected $job = null;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $age = null;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Classes", mappedBy="teacher", cascade={"persist"})
     * @ORM\JoinColumn(name="id", referencedColumnName="teacher_id", onDelete="NULL")
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
     * @return Teacher
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
     * @return Teacher
     */
    public function setLastName($last_name)
    {
        $this->lastName = $last_name;
        return $this;
    }

    /**
     * @return Job|null
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param Job|null $job
     * @return Teacher
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     * @return Teacher
     */
    public function setAge($age)
    {
        $this->age = $age;
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
     * @return Teacher
     */
    public function addClasses(Classes $classes)
    {
        $this->classes->add($classes);
        return $this;
    }
}