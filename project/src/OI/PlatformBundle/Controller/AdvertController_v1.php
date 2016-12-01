<?php

namespace OI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
    public function indexAction(Request $request)
    {
      /*
      $session = $request->getSession(); // on récupère la session
      $session->set('user_name', 'Paolo'); // on écrit dans la session
      $userName = $session->get('user_name'); // on récupère une variable de session

      $friends = ["Mourad", "Nabil", "Yassine"];
      $infos = array(
        "country" => "Maroc",
        "town" => "Casablanca",
        "retired" => false
      );

      return $this->render('OIPlatformBundle:Advert:index.html.twig', array(
        'name' => $userName,
        'age' => 15,
        'friends' => $friends,
        'infos' => $infos
      ));
      */
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
          'author' => 'Chris',
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
      //return $this->render('OIPlatformBundle:Advert:view.html.twig');

      // permet de récupérer la clé tag dans l'url (?tag=)
      $tag = $request->query->get('tag');

      // generateUrl() => retourne l'url par rapport au nom de route fourni en entrée
      //$url = $this->generateUrl('oi_platform_home');

      /*
      return new Response(
        "<p>Vous souhaitez afficher l'annonce: ".$id."
         avec le tag : ".$tag."</p>
        <br><a href=".$url.">Accueil</a>"
      );
      */

      // création d'une reponse, sans contenu à cet instant
      $response = new Response();

      // insertion de contenu dans la réponse
      $response->setContent("<html><body>Tout va bien</body></html>");

      // on définit le statut à erreur 404
      $response->setStatusCode(Response::HTTP_NOT_FOUND);

      return $response;
    }

    public function viewSlugAction($slug, $year, $format) {
      return new Response(
        "On affiche l'annonce "  . $slug . " créée en " . $year . " au format " . $format
      );
    }

    public function addAction(Request $request) {
      /*
      $tag = $request->query->get('tag');
      $session = $request->getSession(); // on récupère la session

      if ($tag == 'redirect') {
        // redirection
        return $this->redirectToRoute('oi_platform_home');
      } else {
        return new Response("Va tutto bene " . $session->get('user_name') );
      }
      */
      return $this->render('OIPlatformBundle:Advert:add.html.twig');

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
