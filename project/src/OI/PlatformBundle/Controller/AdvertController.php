<?php

namespace OI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use OI\PlatformBundle\Entity\Advert;

class AdvertController extends Controller
{
    public function indexAction(Request $request)
    {

      $listAdverts = array(
        array(
          'id' => 1,
          'title' => 'Urgent: recherche développeur Angular',
          'author' => 'Chris',
          'content' => "Dans le cadre d'un partenariat avec le Juventus FC, nous recherchons un développeur à la fois à l'aise avec Angular et habile balle au pied",
          'date' => new \Datetime()),
        array(
          'id' => 2,
          'title' => 'Offre de stage à Montpellier',
          'author' => 'Burdy',
          'content' => "Dans le cadre d'un partenariat avec le Juventus FC, nous recherchons un développeur à la fois à l'aise avec Angular et habile balle au pied",
          'date' => new \Datetime()),
        array(
          'id' => 3,
          'title' => 'Recherche Webdesigner pour mission de 3 mois',
          'author' => 'Chris',
          'content' => "Dans le cadre d'un partenariat avec le Juventus FC, nous recherchons un développeur à la fois à l'aise avec Angular et habile balle au pied",
          'date' => new \Datetime()),
      );

      return $this->render('OIPlatformBundle:Advert:index.html.twig', array(
        'listAdverts' => $listAdverts
      ));
    }

    public function viewAction($id, Request $request) {
      // TODO: requête en db
      $advert = array(
        'id' => 1,
        'title' => 'Urgent: recherche développeur Angular',
        'author' => 'Chris',
        'content' => "Dans le cadre d'un partenariat avec le Juventus FC, nous recherchons un développeur à la fois à l'aise avec Angular et habile balle au pied",
        'date' => new \Datetime());

      return $this->render('OIPlatformBundle:Advert:view.html.twig', array(
        'advert' => $advert
      ));
    }

    public function viewSlugAction($slug, $year, $format) {
      return new Response(
        "On affiche l'annonce "  . $slug . " créée en " . $year . " au format " . $format
      );
    }

    public function addAction(Request $request) {

      $doctrine = $this->get('doctrine');
      // le service doctrine seul ne sert à rien ici
      $em = $doctrine->getManager();
      // on a besoin du service manager pour manipuler les annonces

      $advert = new Advert();
      $advert->setTitle('Recherche développeur Angular');
      $advert->setAuthor('Akli');
      $advert->setContent('Nous avons besoin d\'un développeur Angular de toute urgence');
      $advert->setDate(new \Datetime);

      $em->persist($advert); // étape 1, requête en attente d'exécution
      $em->flush(); // étape 2, exécution des requêtes en attente

      return $this->render('OIPlatformBundle:Advert:add.html.twig', array(

      ));

      // récupération et utilisation du service Antispam
      /*
      $antispam = $this->container->get('oi_platform.antispam');

      $text = 'blablabla'; // variable de test
      if ($antispam->isSpam($text)) {
        return new Response("C'est un spam !");
      } else {
        return new Response("Ce n'est pas un spam !");
      }
      */
    }

    public function editAction($id) {
      // TODO: requête en db
      $advert = array(
        'id' => 1,
        'title' => 'Urgent: recherche développeur Angular',
        'author' => 'Chris',
        'content' => "Dans le cadre d'un partenariat avec le Juventus FC, nous recherchons un développeur à la fois à l'aise avec Angular et habile balle au pied",
        'date' => new \Datetime());

      return $this->render('OIPlatformBundle:Advert:edit.html.twig', array(
        'advert' => $advert
      ));

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
