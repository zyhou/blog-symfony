<?php

namespace SiteBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            throw new NotFoundHttpException('Page"'.$age.'" inexistante');
        }

        return $this->render('SiteBlogBundle:Advert:index.html.twig');
    }

    public function viewAction($id)
    {
        return $this->render(
            'SiteBlogBundle:Advert:view.html.twig',
            array('id' => $id)
        );
    }

    public function addAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirectToRoute('site_blog_view', array('id' => 5));
        }

        return $this->render('SiteBlogBundle:Advert:add.html.twig');
    }

    public function deleteAction($id)
    {
        return $this->render('SiteBlogBundle:Advert:delete.html.twig');
    }

}
