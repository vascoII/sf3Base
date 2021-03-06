<?php

namespace Vasco\CrudBundle\Controller;

use Vasco\CrudBundle\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TodoController extends Controller
{
    public function indexAction(){
        return $this->render('VascoCrudBundle:Todo:index.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/todos", name="todo_list")
     */
    public function listAction()
    {
        $todos = $this->getDoctrine()
                ->getRepository('VascoCrudBundle:Todo')
                ->findAll();
        var_dump($todos); die;
        return $this->render('VascoCrudBundle:Todo:list.html.twig', array(
            'todos' => $todos
        ));
    }
    
    /**
     * @Route("/todossp", name="todosp_list")
     */
    public function listspAction()
    {
        // set doctrine
        $em = $this->getDoctrine()->getManager()->getConnection();
        // prepare statement
        $sth = $em->prepare("CALL list_todos()");
        // execute and fetch
        $sth->execute();
        $result = $sth->fetchAll();
        
        $todo = new Todo();
        $dbTodoHydrator = $this->get('vasco.todobundle.dbtodohydrator');
        $todos = [];
        
        foreach ($result as $res){
            $todos[] = $dbTodoHydrator->hydrate($res, $todo);
        }

        return $this->render('VascoCrudBundle:Todo:list.html.twig', array(
            'todos' => $todos
        ));
    }
    
    
    
    /**
     * @Route("/todo/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $todo = new Todo();
        
        $form = $this->createFormBuilder($todo)
                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('priority', ChoiceType::class, array('choices' => array('Bas' => 'Bas','Moyen' => 'Moyen','Urgent' => 'Urgent'),'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('dueDate', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('Save', SubmitType::class, array('label' => 'Create Todo','attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            // Get Data
            $name       = $form['name']->getData();
            $category   = $form['category']->getData();
            $description = $form['description']->getData();
            $priority   = $form['priority']->getData();
            $dueDate    = $form['dueDate']->getData();
            $now        = new \DateTime('now');
            
            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($dueDate);
            $todo->setCreateDate($now);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            
            $this->addFlash(
                    'notice', 
                    'Todo Added');
            
            return $this->redirectToRoute('todo_list');
        }
        return $this->render('VascoCrudBundle:Todo:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()
                ->getRepository('VascoCrudBundle:Todo')
                ->find($id);
        
        $todo->setName($todo->getName());
        $todo->setCategory($todo->getCategory());
        $todo->setDescription($todo->getDescription());
        $todo->setPriority($todo->getPriority());
        $todo->setDueDate($todo->getDueDate());
            
        $form = $this->createFormBuilder($todo)
                ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('priority', ChoiceType::class, array('choices' => array('Bas' => 'Bas','Moyen' => 'Moyen','Urgent' => 'Urgent'),'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('dueDate', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                ->add('Save', SubmitType::class, array('label' => 'Update Todo','attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            // Get Data
            $name       = $form['name']->getData();
            $category   = $form['category']->getData();
            $description = $form['description']->getData();
            $priority   = $form['priority']->getData();
            $dueDate    = $form['dueDate']->getData();
            $now        = new \DateTime('now');
            
            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('VascoCrudBundle:Todo')->find($id);
            
            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($dueDate);
            $todo->setCreateDate($now);
            
            
            $em->flush();
            
            $this->addFlash(
                    'notice', 
                    'Todo Updated');
            
            return $this->redirectToRoute('todo_list');
        }
        return $this->render('VascoCrudBundle:Todo:edit.html.twig', array(
            'form' => $form->createView()            
        ));
    }

    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()
                ->getRepository('VascoCrudBundle:Todo')
                ->find($id);
        return $this->render('VascoCrudBundle:Todo:details.html.twig', array(
            'todo' => $todo
        ));
    }
    
    /**
     * @Route("/todo/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('VascoCrudBundle:Todo')->find($id);
        
        $em->remove($todo);
        $em->flush();
            
        $this->addFlash(
                'notice', 
                'Todo Removed');
            
        return $this->redirectToRoute('todo_list');
        
    }

}
