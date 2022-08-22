<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorControllertController extends AbstractController
{
    /**
     * @Route("/error/controllert", name="app_error_controllert")
     */
    public function index(): Response
    {
        return $this->render('error_controllert/index.html.twig', [
            'controller_name' => 'ErrorControllertController',
        ]);
    }
}
