<?php

namespace OI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use OI\PlatformBundle\Form\CategoryType;
use OI\PlatformBundle\Entity\Category;

class CategoryController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $categories = $em->getRepository('OIPlatformBundle:Category')->findAll();

      return $this->render('OIPlatformBundle:Category:index.html.twig', array(
        'categories' => $categories
      ));
    }
    public function addAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        if ($request->isMethod('POST')) {
          if ($form->handleRequest($request) && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('oi_platform_categories');
          }
        }

        return $this->render('OIPlatformBundle:Category:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
