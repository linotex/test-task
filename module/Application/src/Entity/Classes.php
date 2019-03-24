<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="classes")
 */
class Classes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(nullable=false)
     */
    protected $name = null;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $day = null;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $room = null;

    /**
     * @ORM\Column(name="start_hour", type="integer", nullable=false)
     */
    protected $start_hour = null;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Teacher", inversedBy="classes", cascade={"persist"})
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", onDelete="NULL")
     */
    protected $teacher = null;

    /**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Student")
     * @ORM\JoinTable(name="student_to_classes",
     *      joinColumns={@ORM\JoinColumn(name="classes_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="student_id", referencedColumnName="id")}
     *      )
     */
    protected $students = null;

    public function __construct()
    {
        $this->students = new ArrayCollection();
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
     * @return Classes
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     * @return Classes
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     * @return Classes
     */
    public function setRoom($room)
    {
        $this->room = $room;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartHour()
    {
        return $this->startHour;
    }

    /**
     * @param mixed $start_hour
     * @return Classes
     */
    public function setStartHour($start_hour)
    {
        $this->startHour = $start_hour;
        return $this;
    }

    /**
     * @return Teacher|null
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param Teacher|null $teacher
     * @return Classes
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @return array
     */
    public function getStudents()
    {
        return $this->students->getValues();
    }

    /**
     * @param Student $student
     * @return Classes
     */
    public function addStudent(Student $student)
    {
        $this->students->add($student);
        return $this;
    }

    /**
     * @param Student $student
     * @return Classes
     */
    public function removeStudent(Student $student)
    {
        $this->students->removeElement($student);
        return $this;
    }

    /**
     * @param Student $student
     * @return bool
     */
    public function studentIsAdded(Student $student)
    {
        return $this->students->contains($student);
    }
}