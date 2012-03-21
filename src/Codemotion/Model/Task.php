<?php

namespace Codemotion\Model;

/**
 * @Entity @Table(name="task")
 **/
class Task
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="string")
     */
    protected $state;

    /**
     * @OneToMany(targetEntity="Item", mappedBy="task", cascade={"all"})
     */
    protected $items;
}
