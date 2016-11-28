<?php

namespace OI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
    public function indexAction(Request $request)
    {
      $session = $request->getSession(); // on récupère la session

      $session->set('user_name', 'Paolo'); // on écrit dans la session
      $userName = $session->get('user_name'); // on récupère une variable de session


      return $this->render('OIPlatformBundle:Advert:index.html.twig', array(
        'name' => $userName,
        'age' => 25
      ));
    }

    public function viewAction($id, Request $request) {
      //return $this->render('OIPlatformBundle:Advert:view.html.twig');

      // permet de récupérer la clé tag dans l'url (?tag=)
      $tag = $request->query->get('tag');

      // generateUrl() => retourne l'url par rapport au nom de route fourni en entrée
      $url = $this->generateUrl('oi_platform_home');

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

      $tag = $request->query->get('tag');
      $session = $request->getSession(); // on récupère la session

      if ($tag == 'redirect') {
        // redirection
        return $this->redirectToRoute('oi_platform_home');
      } else {
        return new Response("Va tutto bene " . $session->get('user_name') );
      }

    }
}
