<?php

namespace Models;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UsersModel
 * @Entity()
 * @Table(name="users")
 * @package Models
 */
class UsersModel implements UserInterface
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

    /**
     * Many Users have Many Role.
     * @ManyToMany(targetEntity="Role")
     * @JoinTable(name="users_has_role",
     *      joinColumns={@JoinColumn(name="users_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    private $roles = [];

    /** @Column(name="password", type="string", length=255, nullable=false) */
    private $password;

    //endregion

    //region methodes
    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'roles' => $this->getRoles(),
            'password' => $this->password
        ];
    }

    /**
     * @return null|string|void
     */
    public function getSalt()
    {
        return ;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
        return ;
    }

    //endregion

    //region getter and setter
    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /** @return string */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /** @return string */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /** @return array */
    public function getRoles():array
    {
        $roles = [];
        foreach ($this->roles as $role){
            $roles[] = $role->getLabel();
        }
        return $roles;
    }


    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = [];
        foreach ($roles as $role){
            $this->addRole($role);
        }
        return $this;
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function addRole(Role $role){
        if (in_array($role, $this->roles)){
            return $this;
        }
        $this->roles[] = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    //endregion

}