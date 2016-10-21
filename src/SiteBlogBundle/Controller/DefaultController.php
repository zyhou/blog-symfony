<?php

namespace SiteBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteBlogBundle:Default:index.html.twig');
    }
}
