<?php

namespace Vikan\WashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $mieleService = $this->get('vikan_wash.miele_service');
        $laundryPlaces = $mieleService->getLaundryPlaces();

        foreach ($laundryPlaces as $k => &$v) {
            $mieleService->setLaundryState($v);
        }
        return $this->render('VikanWashBundle:Default:index.html.twig', ['laundryStates' => $laundryPlaces]);
    }
}
