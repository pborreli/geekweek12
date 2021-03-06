<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;

class CheeseController extends Controller
{
    public function indexAction()
    {
        return array('cheeses' => $this->getRepository()->findAll(true, 3));
    }

    public function listRegionAction()
    {
        return $this->render('App:Cheese:listRegion.html.twig', array(
            'regions' => $this->getRepository()->findRegions(),
        ));
    }

    public function listMilkAction()
    {
        return $this->render('App:Cheese:listMilk.html.twig', array(
            'milks' => $this->getRepository()->findMilks(),
        ));
    }

    private function getRepository()
    {
        return $this->getDoctrine()->getEntityManager()->getRepository('App\Entity\Cheese');
    }
}
