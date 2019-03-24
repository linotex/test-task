<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jobs")
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", nullable=false)
     */
    protected $name = null;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Teacher", mappedBy="job", cascade={"persist"})
     * @ORM\JoinColumn(name="id", referencedColumnName="job_id", onDelete="NULL")
     */
    protected $teachers = null;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Job
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getTeachers()
    {
        return $this->teachers->getValues();
    }

    /**
     * @param Teacher $teacher
     * @return Job
     */
    public function addTeacher(Teacher $teacher)
    {
        $this->teachers->add($teacher);
        return $this;
    }
}