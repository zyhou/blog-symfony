<?php

namespace SiteBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use SiteBlogBundle\Entity\Advert;
use SiteBlogBundle\Form\AdvertType;
use SiteBlogBundle\Entity\Image;
use SiteBlogBundle\Entity\Application;
use SiteBlogBundle\Entity\AdvertSkill;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        $nbPerPage = 3;
        $listAdverts = $this->getDoctrine()->getManager()->getRepository('SiteBlogBundle:Advert')->getAdverts($page, $nbPerPage);

        $nbPages = ceil(count($listAdverts)/$nbPerPage);
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return $this->render('SiteBlogBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts,
            'nbPages' => $nbPages,
            'page' => $page
        ));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('SiteBlogBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $listAdvertSkills = $em->getRepository('SiteBlogBundle:AdvertSkill')->findBy(array('advert' => $advert));

        return $this->render('SiteBlogBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listAdvertSkills' => $listAdvertSkills
        ));
    }

    public function addAction(Request $request)
    {
        $advert = new Advert();
        $form = $this->createForm(new AdvertType(), $advert);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirect($this->generateUrl('site_blog_view', array('id' => $advert->getId())));
        }

        return $this->render('SiteBlogBundle:Advert:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('SiteBlogBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $form = $this->createForm(new AdvertEditType(), $advert);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
            return $this->redirect($this->generateUrl('oc_platform_view', array('id' => $advert->getId())));
        }

        return $this->render('SiteBlogBundle:Advert:edit.html.twig', array(
            'form'   => $form->createView(),
            'advert' => $advert // Je passe également l'annonce à la vue si jamais elle veut l'afficher
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('SiteBlogBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($advert);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
            return $this->redirect($this->generateUrl('site_blog_home'));
        }

        return $this->render('SiteBlogBundle:Advert:delete.html.twig', array(
            'advert' => $advert,
            'form'   => $form->createView()
        ));
    }

    public function menuAction($limit = 3)
    {
        $listAdverts = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('SiteBlogBundle:Advert')
                            ->findBy(
                                array(),                 // Pas de critère
                                array('date' => 'desc'),
                                $limit,
                                0
                            );

        return $this->render('SiteBlogBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }
//
//    public function editImageAction($advertId)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $advert = $em->getRepository('$listAdverts:Advert')->find($advertId);
//        $advert->getImage()->setUrl('test.png');
//
//        // On n'a pas besoin de persister l'annonce ni l'image vue qu'on récupére de doctrine directement
//        $em->flush();
//
//        return new response('ok');
//    }
//
//    public function testSlugAction()
//    {
//        $advert = new Advert();
//        $advert->setAuthor("Test");
//        $advert->setContent("Test");
//        $advert->setTitle("Recherche développeur !");
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($advert);
//        $em->flush();
//        return new Response('Slug généré : '.$advert->getSlug());
//    }

}
