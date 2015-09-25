<?php

namespace FormaLibre\HoraireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="formalibre_horairebundle_period")
 * @ORM\Entity
 */
class Period
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="schoolYearName", type="string", length=255)
     */
    private $periodName;
    /**
     * @ORM\Column(name="schoolYear_begin",type="date")
     */
    protected $periodBegin;
     /**
     * @ORM\Column(name="schoolYear_end",type="date")
     */
    protected $periodEnd;
        /**
     * @ORM\Column(name="schoolDay_begin_hour",type="time")
     */
    protected $periodBeginHour;
    
    /**
     * @ORM\Column(name="schoolDay_end_hour",type="time")
     */
    protected $periodEndHour;
     /**
     * @var string
     *
     * @ORM\Column(name="visibility", type="boolean" )
     */
    private $Visibility = false;
    
    function getId() {
        return $this->id;
    }

    function getPeriodName() {
        return $this->periodName;
    }

    function getPeriodBegin() {
        return $this->periodBegin;
    }

    function getPeriodEnd() {
        return $this->periodEnd;
    }

    function getPeriodBeginHour() {
        return $this->periodBeginHour;
    }

    function getPeriodEndHour() {
        return $this->periodEndHour;
    }

    function getVisibility() {
        return $this->Visibility;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPeriodName($periodName) {
        $this->periodName = $periodName;
    }

    function setPeriodBegin($periodBegin) {
        $this->periodBegin = $periodBegin;
    }

    function setPeriodEnd($periodEnd) {
        $this->periodEnd = $periodEnd;
    }

    function setPeriodBeginHour($periodBeginHour) {
        $this->periodBeginHour = $periodBeginHour;
    }

    function setPeriodEndHour($periodEndHour) {
        $this->periodEndHour = $periodEndHour;
    }

    function setVisibility($Visibility) {
        $this->Visibility = $Visibility;
    }



}

