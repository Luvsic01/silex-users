<?php

namespace Models;

/**
 * Class UsersModel
 * @Entity()
 * @Table(name="users")
 * @package Models
 */
class UsersModel
{
    //region params
    /** @Id()
     *  @GeneratedValue()
     *  @Column(name="id", type="integer", nullable=false) */
    protected $id;

    /** @Column(name="firstname", type="string", length=30, nullable=false) */
    private $firstname;

    /** @Column(type="string", type="string", length=30, nullable=false) */
    private $lastname;
    //endregion

    //region methodes
    public function toArray(){
        return [
          'id'=>$this->id,
          'firstname'=>$this->firstname,
          'lastname'=>$this->lastname
        ];
    }
    //endregion

    //region getter and setter
    /** @return mixed */
    public function getId()
    {
        return $this->id;
    }

    /** @return mixed */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /** @param mixed $firstname */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /** @return mixed */
    public function getLastname()
    {
        return $this->lastname;
    }

    /** @param mixed $lastname */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }
    //endregion

}