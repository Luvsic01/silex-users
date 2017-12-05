<?php

namespace Models;

/**
 * Class roloe
 * @Entity()
 * @Table(name="role")
 * @package Models
 */
class role
{
    /** @Id()
     * @GeneratedValue()
     * @Column(name="id", type="integer", nullable=false)
     */
    protected $id;

    /** @Column(name="label", type="string", length=32, nullable=false) */
    private $label;

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

}