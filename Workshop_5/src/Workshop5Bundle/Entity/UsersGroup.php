<?php

namespace Workshop5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * UsersGroup
 *
 * @ORM\Table(name="users_group")
 * @ORM\Entity(repositoryClass="Workshop5Bundle\Repository\UsersGroupRepository")
 */
class UsersGroup {

    /**
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="groups")
     */
    private $persons;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return UsersGroup
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groups
     *
     * @param \Workshop5Bundle\Entity\UsersGroup $groups
     * @return UsersGroup
     */
    public function addGroup(\Workshop5Bundle\Entity\UsersGroup $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Workshop5Bundle\Entity\UsersGroup $groups
     */
    public function removeGroup(\Workshop5Bundle\Entity\UsersGroup $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    public function __toString() {
        return $this->name;
    }

    /**
     * Add persons
     *
     * @param \Workshop5Bundle\Entity\Person $persons
     * @return UsersGroup
     */
    public function addPerson(\Workshop5Bundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;

        return $this;
    }

    /**
     * Remove persons
     *
     * @param \Workshop5Bundle\Entity\Person $persons
     */
    public function removePerson(\Workshop5Bundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }
    
    
}
