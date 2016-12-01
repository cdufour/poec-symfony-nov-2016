<?php

namespace OI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use OI\PlatformBundle\Entity\Advert;
use OI\PlatformBundle\Entity\Image;
use OI\PlatformBundle\Entity\Application;
use OI\PlatformBundle\Entity\Category;

/*
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
*/

use OI\PlatformBundle\Form\AdvertType;

class AdvertController extends Controller
{
    public function indexAction(Request $request)
    {

      $em = $this->getDoctrine()
        ->getManager()
        ->getRepository('OIPlatformBundle:Advert');

      $listAdverts = $em->findAll();

      return $this->render('OIPlatformBundle:Advert:index.html.twig', array(
        'listAdverts' => $listAdverts
      ));
    }

    public function viewAction($id, Request $request)
    {

      $em = $this->getDoctrine()
        ->getManager()
        ->getRepository('OIPlatformBundle:Advert');

      $advert = $em->find($id);

      return $this->render('OIPlatformBundle:Advert:view.html.twig', array(
        'advert' => $advert
      ));
    }

    public function viewSlugAction($slug, $year, $format)
    {
      return new Response(
        "On affiche l'annonce "  . $slug . " créée en " . $year . " au format " . $format
      );
    }

    public function addAction(Request $request)
    {
      $advert = new Advert();
      /*
      $form = $this->get('form.factory')->createBuilder(FormType::class, $advert)
        ->add('date',       DateType::class)
        ->add('title',      TextType::class)
        ->add('author',     TextType::class)
        ->add('content',    TextareaType::class)
        ->add('published',  CheckboxType::class)
        ->add('save',       SubmitType::class)
        ->getForm();
      */
      $form = $this->createForm(AdvertType::class, $advert);

      if ($request->isMethod('POST')) { // formulaire soumis
        // handleRequest hydrate les champs de l'entité avec les données postées
        if ($form->handleRequest($request) && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();

          //upload de l'image
          $advert->getImage()->upload();

          $em->persist($advert);
          $em->flush();

          return $this->redirectToRoute('oi_platform_home');
        }
      }

      return $this->render('OIPlatformBundle:Advert:add.html.twig', array(
        'form' => $form->createView()
      ));
    }

    public function editAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $advert = $em->getRepository('OIPlatformBundle:Advert')->find($id);
      $form = $this->createForm(AdvertType::class, $advert);

      if ($advert === null) return new Response('id introuvable');

      if ($request->isMethod('POST')) {
        if ($form->handleRequest($request) && $form->isValid()) {
          //upload de l'image
          $advert->getImage()->upload();

          $em->flush();
          return $this->redirectToRoute('oi_platform_view', array(
            'id'=>$advert->getId()));
        }
      }

      return $this->render('OIPlatformBundle:Advert:edit.html.twig', array(
        'advert' => $advert,
        'form' => $form->createView()
      ));
    }

    public function deleteAction($id)
    {
      // Todo: demander une confirmation avant suppression
      // Todo: s'assurer que l'image est supprimée également
      $em = $this->getDoctrine()->getManager();
      $advert = $em->getRepository('OIPlatformBundle:Advert')->find($id);

      if ($advert === null) return new Response('id introuvable');

      $em->remove($advert);
      $em->flush();

      return $this->redirectToRoute('oi_platform_home');
    }

    public function marketAction() {
      // définition des données "en dur"
      // on verra plus tard comment obtenir ces données depuis une base de données
      $products = array(
        array("name" => "Pomme", "type" => "fruit", "calories" => 10),
        array("name" => "Carotte", "type" => "légume", "calories" => 9),
        array("name" => "Mangue", "type" => "fruit", "calories" => 20),
        array("name" => "Noisette", "type" => "fruit", "calories" => 14),
        array("name" => "Chou-fleur", "type" => "légume", "calories" => 18)
      );
      return $this->render('OIPlatformBundle:Advert:market.html.twig', array(
        'products' => $products
      ));
    }

    public function menuAction($limit) {
      // liste des annonces "en dur"
      // TODO: replacer par requête en db
      $listAdverts = array(
        array('id' => 1, 'title' => 'Urgent: recherche développeur Angular'),
        array('id' => 2, 'title' => 'Offre de stage à Montpellier'),
        array('id' => 3, 'title' => 'Recherche Webdesigner pour mission de 3 mois')
      );

      return $this->render('OIPlatformBundle:Advert:menu.html.twig', array(
        'listAdverts' => $listAdverts
      ));
    }

}
