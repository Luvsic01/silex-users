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
     * @GeneratedValue()
     * @Column(name="id", type="integer", nullable=false)
     */
    protected $id;

    /** @Column(name="firstname", type="string", length=64, nullable=false) */
    private $firstname;

    /** @Column(name="lastname", type="string", length=64, nullable=false) */
    private $lastname;

    /** @Column(name="username", type="string", length=32, nullable=false) */
    private $username;

    /** @Column(name="role", type="string", length=32, nullable=false) */
    private $role;

    /** @Column(name="password", type="string", length=255, nullable=false) */
    private $password;

    //endregion

    //region methodes
    public function toArray()
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'role' => $this->role
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

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    //endregion

}