<?php

namespace SiteBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdvertController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('SiteBlogBundle:Advert:index.html.twig', array(
            'nom' => 'Maxime',
            'advert_id' => '5'
        ));
        return new Response($content);
    }

    public function viewAction($id)
    {
        return $this->render(
            'SiteBlogBundle:Advert:view.html.twig',
            array('id'  => $id)
        );
    }

}
