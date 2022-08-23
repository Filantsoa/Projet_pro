<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccuelController extends AbstractController
{
    /**
     * @Route("/accuel", name="app_accuel")
     */
    public function index(): Response
    {
        return $this->render('accuel/index.html.twig', [
            'controller_name' => 'AccuelController',
        ]);
    }
}
