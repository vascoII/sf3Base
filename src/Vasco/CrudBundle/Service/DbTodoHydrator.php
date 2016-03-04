<?php

namespace Vasco\CrudBundle\Service;

use Vasco\CrudBundle\Entity\Todo;
use Doctrine\ORM\EntityManager;

class DbTodoHydrator{
    
    protected $em;

    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {   
        if (!$object instanceof Todo)
        {
            throw new \Exception('The specified object is not a Todo');
        }
      
        // Get user.
        $user = $this->em->getRepository('VascoUserBundle:User')
                ->find($data['user_id']);
        
        //Set Object
        $object->setId($data['id']);
        $object->setName($data['name']);
        $object->setCategory($data['category']);
        $object->setDescription($data['description']);
        $object->setPriority($data['priority']);
        $object->setDueDate($data['due_date']);
        $object->setCreateDate($data['create_date']);
        $object->setUser($user);
        
        return $object;
    }
}
