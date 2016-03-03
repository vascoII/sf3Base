<?php
// src/Vasco/UserBundle/Entity/User.php

namespace Vasco\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @ORM\OneToMany(targetEntity="Vasco\CrudBundle\Entity\Todo", mappedBy="todo", cascade={"remove", "persist"})
    */
    protected $todos;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add todo
     *
     * @param \Vasco\CrudBundle\Entity\Todo $todo
     *
     * @return User
     */
    public function addTodo(\Vasco\CrudBundle\Entity\Todo $todo)
    {
        $this->todos[] = $todo;

        return $this;
    }

    /**
     * Remove todo
     *
     * @param \Vasco\CrudBundle\Entity\Todo $todo
     */
    public function removeTodo(\Vasco\CrudBundle\Entity\Todo $todo)
    {
        $this->todos->removeElement($todo);
    }

    /**
     * Get todos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTodos()
    {
        return $this->todos;
    }
}
