<?php

namespace OI\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OITestBundle:Default:index.html.twig');
    }

    public function listAction() {
      return new Response('<html><body>liste des clients</body></html>');
    }
}
