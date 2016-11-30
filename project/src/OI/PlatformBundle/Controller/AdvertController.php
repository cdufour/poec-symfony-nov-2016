<?php

namespace OI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use OI\PlatformBundle\Entity\Advert;
use OI\PlatformBundle\Entity\Image;
use OI\PlatformBundle\Entity\Application;
use OI\PlatformBundle\Entity\Category;

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

    public function viewAction($id, Request $request) {

      $em = $this->getDoctrine()
        ->getManager()
        ->getRepository('OIPlatformBundle:Advert');

      $advert = $em->find($id);

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
      $advert->setTitle('Recherche expert en Symfony');
      $advert->setAuthor('Brice');
      $advert->setContent('Aucune qualité musicale exigée');
      //$advert->setDate(new \Datetime); instruction exécutée dans le constructeur
      $advert->setPublished(true);

      /*
      $image = new Image();
      $image->setUrl("http://www.malgradotuttoweb.it/wp-content/uploads/colosseo-roma.jpg");
      $image->setAlt("Colysée vu du ciel");

      $advert->setImage($image); // association de l'annonce et de l'image
      */

      // création d'une première candidature
      $application1 = new Application();
      $application1->setAuthor('John');
      $application1->setContent("Je suis le maître absolu du framework ! J'exige ce poste.");

      // création d'une deuxième candidature
      $application2 = new Application();
      $application2->setAuthor('Fabien Potencier');
      $application2->setContent("Je pense avoir les compétences");

      // on lie les candidateurs à l'annonce
      $application1->setAdvert($advert);
      $application2->setAdvert($advert);


      $em->persist($advert); // étape 1, requête en attente d'exécution
      $em->persist($application1);
      $em->persist($application2);
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

      $em = $this->getDoctrine()->getManager();

      $advert = $em->getRepository('OIPlatformBundle:Advert')->find($id);

      if ($advert === null) {
        return new Response('id introuvable');
      }

      $listCategories = $em->getRepository('OIPlatformBundle:Category')->findAll();

      foreach($listCategories as $category) {
        $advert->addCategory($category);
      }

      // Pas besoin de persist ici car l'entité a déjà été récupérée
      // il ne s'agit pas d'une création
      $em->flush();

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

    public function categoryAddAction()
    {
      $names = array(
        'Développement web',
        'Développement mobile',
        'Angularjs',
        'Symfony',
        'jQuery'
      );

      // récupération du manager
      $em = $this->getDoctrine()->getManager();

      foreach($names as $name) {
        $category = new Category();
        $category->setName($name);
        $em->persist($category);
      }

      $em->flush();

      return new Response('<html><body>OK</body></html>');

    }
}
