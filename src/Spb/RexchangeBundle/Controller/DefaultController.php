<?php

namespace Spb\RexchangeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SpbRexchangeBundle:Default:index.html.twig', array('name' => $name));
    }
}
