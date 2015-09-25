<?php

namespace FormaLibre\HoraireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="formalibre_horairebundle_timeslot")
 */
 class TimeSlot
{
    
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     * @ORM\ManyToOne(
     *     targetEntity="FormaLibre\HoraireBundle\Entity\Period"
     * )
     * @ORM\JoinColumn(name="period_id", onDelete="CASCADE")
     */
    protected $PeriodId;
    /**
     * @ORM\Column(name="num_period")
     */
    protected $name;
    /**
     * @ORM\Column(name="date",type="date")
     */
    protected $date;
     /**
     * @ORM\Column(name="day")
     */
    protected $day;
    /**
     * @ORM\Column(name="begin_hour",type="time")
     */
    protected $beginHour;
    
    /**
     * @ORM\Column(name="end_hour",type="time")
     */
    protected $endHour;
    
    function getId() {
        return $this->id;
    }

    function getPeriodId() {
        return $this->PeriodId;
    }

    function getName() {
        return $this->name;
    }

    function getDate() {
        return $this->date;
    }

    function getDay() {
        return $this->day;
    }

    function getBeginHour() {
        return $this->beginHour;
    }

    function getEndHour() {
        return $this->endHour;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPeriodId($PeriodId) {
        $this->PeriodId = $PeriodId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setDay($day) {
        $this->day = $day;
    }

    function setBeginHour($beginHour) {
        $this->beginHour = $beginHour;
    }

    function setEndHour($endHour) {
        $this->endHour = $endHour;
    }



}

