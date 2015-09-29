<?php

namespace FormaLibre\HoraireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="formalibre_horairebundle_personnalTimeSlot")
 * @ORM\Entity
 */
class PersonnalTimeSlot
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
     * @ORM\ManyToOne(
     *     targetEntity="FormaLibre\HoraireBundle\Entity\TimeSlot"
     * )
     * @ORM\JoinColumn(name="timeSlot_id", onDelete="CASCADE")
     */
    protected $timeSlotId;
    /**
     * @ORM\Column(name="cursus_name")
     */
    protected $cursusName;
     /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\User"
     * )
     * @ORM\JoinColumn(name="teacher_id", onDelete="CASCADE")
     */
    protected $teacherId;
       /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\Group"
     * )
     * @ORM\JoinColumn(name="group_id", onDelete="CASCADE")
     */
    protected $groupId;
       /**
     * @ORM\ManyToOne(
     *     targetEntity="FormaLibre\ReservationBundle\Entity\Resource"
     * )
     * @ORM\JoinColumn(name="local_id", onDelete="CASCADE", nullable=true)
     */
    protected $localId;
       /**
     * @ORM\ManyToOne(
     *     targetEntity="FormaLibre\ReservationBundle\Entity\Reservation"
     * )
     * @ORM\JoinColumn(name="local_reservation_id", onDelete="CASCADE", nullable=true)
     */
    protected $localReservationId;
    
    function getId() {
        return $this->id;
    }

    function getTimeSlotId() {
        return $this->timeSlotId;
    }

    function getCursusName() {
        return $this->cursusName;
    }

    function getTeacherId() {
        return $this->teacherId;
    }

    function getGroupId() {
        return $this->groupId;
    }

    function getLocalId() {
        return $this->localId;
    }

    function getLocalReservationId() {
        return $this->localReservationId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTimeSlotId($timeSlotId) {
        $this->timeSlotId = $timeSlotId;
    }

    function setCursusName($cursusName) {
        $this->cursusName = $cursusName;
    }

    function setTeacherId($teacherId) {
        $this->teacherId = $teacherId;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    function setLocalId($localId) {
        $this->localId = $localId;
    }

    function setLocalReservationId($localReservationId) {
        $this->localReservationId = $localReservationId;
    }


    
    
    
}