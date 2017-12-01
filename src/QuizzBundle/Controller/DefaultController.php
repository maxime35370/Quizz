<?php

namespace QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/quizztest")
     */
    public function indexAction()
    {
        return $this->render('QuizzBundle:Default:index.html.twig');
    }
}
