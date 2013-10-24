<?php

namespace Vikan\WashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LaundryController extends Controller
{
    public function showAction($slug)
    {
        $mieleService = $this->get('vikan_wash.miele_service');
        $laundryPlaces= $mieleService->getLaundryPlaces();

        if (! isset($laundryPlaces[$slug]))
            throw $this->createNotFoundException('Here be dragons!');

        $mieleService->setLaundryState($laundryPlaces[$slug]);

        return $this->render('VikanWashBundle:Laundry:show.html.twig', [
            'laundryPlace' => $laundryPlaces[$slug],
        ]);
    }

}
