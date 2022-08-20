<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UtlisateurController extends AbstractController
{
    /**
     * @Route("/utlisateur", name="app_utlisateur")
     */
    public function index(UsersRepository $utilisateur): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $utilisateur->findAll(),
        ]);
    }

    /**
     *@Route("/utilisateur/modif/{id}", name="utilisateur_modif")
     */
    public function utilisateurModif(Users $utilisateur, Request $request)
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisatuer modifier avec Succes ♠♠♠');
            return $this->redirectToRoute('app_utlisateur');
        }

        return $this->render('utilisateur/utilisateur_modif.html.twig', [
            'utilisateur_modif' => $form->createView(),
        ]);
    }
}
