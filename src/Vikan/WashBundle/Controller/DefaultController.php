<?php

namespace Vikan\WashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $washingPlaces = [
            ["http://129.241.156.6/", "Moholt Alle 20"],
            ["http://129.241.128.7/", "Bregnevegen 65 / Aktivitetshuset på Moholt"],
            ["http://129.241.136.17/", "Karinelund"],
            ["http://129.241.126.11/", "Berg"],
            ["http://129.241.158.20/", "Bloksberg"],
            ["http://129.241.124.32/", "Nedre Singsakerslette"],
            ["http://129.241.146.33/", "Nedre Berg"],
            ["http://129.241.123.40/", "Steinan"],
            ["http://129.241.152.11/", "Teknobyen"],
            ["http://129.241.161.227", "Lerkendal"],
        ];
        $mieleService = $this->get('vikan_wash.miele_service');
        $laundryStates = [];

        foreach ($washingPlaces as $washingPlace) {
            $laundryState = $mieleService->getLaundryState($washingPlace[0]);
            $laundryState['name'] = $washingPlace[1];
            $laundryStates[] = $laundryState;
        }
        return $this->render('VikanWashBundle:Default:index.html.twig', ['laundryStates' => $laundryStates]);
    }
}
