<?php
namespace OI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TraineeController extends Controller
{
  public function listAction()
  {
    $trainees = array('Akli', 'Burdy', 'M. Nguyen','Sara','Karim', 'Muriel', 'Brice');
    $response = new JsonResponse();
    $response->setData($trainees);

    return $response;
  }
}
