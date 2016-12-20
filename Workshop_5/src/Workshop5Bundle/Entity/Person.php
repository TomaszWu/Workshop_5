<?php

namespace Workshop5Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="Workshop5Bundle\Repository\PersonRepository")
 */
class Person {

    /**
     * @ORM\ManyToMany(targetEntity="UsersGroup", inversedBy="persons")
     * @ORM\JoinTable(name="users_group_person")
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="person", cascade={"remove"})
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Telephone", mappedBy="person", cascade={"remove"})
     */
    private $telephones;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="person", cascade={"remove"})
     */
    private $mailes;

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
     * @Assert\Length(min=5,
     * minMessage = "Długość imienia to minimum 5 znaków."
     * )
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(min=5,
     * minMessage = "Długość naziwska to minimum 5 znaków."
     * )
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     * @Assert\Length(min=8,
     * minMessage = "Długość opisu to minimum 8 znaków."
     * )
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * Get id
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Person
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
     * Set surname
     *
     * @param string $surname
     * @return Person
     */
    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Person
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->telephones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mailes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add addresses
     *
     * @param \Workshop5Bundle\Entity\Address $addresses
     * @return Person
     */
    public function addAddress(\Workshop5Bundle\Entity\Address $addresses) {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \Workshop5Bundle\Entity\Address $addresses
     */
    public function removeAddress(\Workshop5Bundle\Entity\Address $addresses) {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses() {
        return $this->addresses;
    }

    /**
     * Add telephones
     *
     * @param \Workshop5Bundle\Entity\Telephone $telephones
     * @return Person
     */
    public function addTelephone(\Workshop5Bundle\Entity\Telephone $telephones) {
        $this->telephones[] = $telephones;

        return $this;
    }

    /**
     * Remove telephones
     *
     * @param \Workshop5Bundle\Entity\Telephone $telephones
     */
    public function removeTelephone(\Workshop5Bundle\Entity\Telephone $telephones) {
        $this->telephones->removeElement($telephones);
    }

    /**
     * Get telephones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTelephones() {
        return $this->telephones;
    }

    /**
     * Add mailes
     *
     * @param \Workshop5Bundle\Entity\Email $mailes
     * @return Person
     */
    public function addMaile(\Workshop5Bundle\Entity\Email $mailes) {
        $this->mailes[] = $mailes;

        return $this;
    }

    /**
     * Remove mailes
     *
     * @param \Workshop5Bundle\Entity\Email $mailes
     */
    public function removeMaile(\Workshop5Bundle\Entity\Email $mailes) {
        $this->mailes->removeElement($mailes);
    }

    /**
     * Get mailes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMailes() {
        return $this->mailes;
    }

    /**
     * Add users
     *
     * @param \Workshop5Bundle\Entity\User $users
     * @return Person
     */
    public function addUser(\Workshop5Bundle\Entity\User $users) {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Workshop5Bundle\Entity\User $users
     */
    public function removeUser(\Workshop5Bundle\Entity\User $users) {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers() {
        return $this->users;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * Add groups
     *
     * @param \Workshop5Bundle\Entity\UsersGroup $groups
     * @return Person
     */
    public function addGroup(\Workshop5Bundle\Entity\UsersGroup $groups) {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Workshop5Bundle\Entity\UsersGroup $groups
     */
    public function removeGroup(\Workshop5Bundle\Entity\UsersGroup $groups) {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups() {
        return $this->groups;
    }

    static function cmp_obj($a, $b) {
        $al = strtolower($a->name);
        $bl = strtolower($b->name);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }

}
