<?php

namespace FormaLibre\HoraireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Claroline\CoreBundle\Entity\Role;

/**
 * @ORM\Entity(repositoryClass="FormaLibre\HoraireBundle\Repository\HoraireRightsRepository")    
 * @ORM\Table(name="formalibre_horairebundle_rights")
 */
 class PresenceRights
{
     const PERSONNAL_PLANNING = 1;
     const TEACHERS_PLANNING = 2;
     const GROUP_PLANNING = 4;

     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\Role"
     * )
     * @ORM\JoinColumn(name="role_id", onDelete="CASCADE")
     */
    protected  $role;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $mask;
    
    function getId() {
        return $this->id;
    }

    function getRole() {
        return $this->role;
    }

    function getMask() {
        return $this->mask;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRole(Role $role) {
        $this->role = $role;
    }

    function setMask($mask) {
        $this->mask = $mask;
    }


}
