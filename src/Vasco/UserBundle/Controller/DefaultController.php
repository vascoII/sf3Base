<?php

namespace Vasco\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VascoUserBundle:Default:index.html.twig', array());
    }
}
