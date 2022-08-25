<?php

namespace App\Controller;

use App\Entity\ProfTitulaire;
use App\Form\ProfTitulaireType;
use App\Repository\ProfTitulaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/prof/titulaire")
 */
class ProfTitulaireController extends AbstractController
{
    /**
     * @Route("/", name="app_prof_titulaire_index", methods={"GET"})
     */
    public function index(Request $request, ProfTitulaireRepository $profTitulaireRepository, PaginatorInterface $paginator): Response
    {
        $donnes = $this->getDoctrine()->getRepository(ProfTitulaire::class)->findBy([],['nom' => 'desc']);

        // $queryBuilder = $profTitulaireRepository->getWithSerchQueryBuilder($q);
        $profTitulaire = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('prof_titulaire/index.html.twig', [
            'prof_titulaires' => $profTitulaire,
        ]);
    }

    /**
     * @Route("/new", name="app_prof_titulaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProfTitulaireRepository $profTitulaireRepository): Response
    {
        $profTitulaire = new ProfTitulaire();
        $form = $this->createForm(ProfTitulaireType::class, $profTitulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profTitulaireRepository->add($profTitulaire, true);

            return $this->redirectToRoute('app_prof_titulaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prof_titulaire/new.html.twig', [
            'prof_titulaire' => $profTitulaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_prof_titulaire_show", methods={"GET"})
     */
    public function show(ProfTitulaire $profTitulaire): Response
    {
        return $this->render('prof_titulaire/show.html.twig', [
            'prof_titulaire' => $profTitulaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_prof_titulaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ProfTitulaire $profTitulaire, ProfTitulaireRepository $profTitulaireRepository): Response
    {
        $form = $this->createForm(ProfTitulaireType::class, $profTitulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profTitulaireRepository->add($profTitulaire, true);

            return $this->redirectToRoute('app_prof_titulaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prof_titulaire/edit.html.twig', [
            'prof_titulaire' => $profTitulaire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_prof_titulaire_delete", methods={"POST"})
     */
    public function delete(Request $request, ProfTitulaire $profTitulaire, ProfTitulaireRepository $profTitulaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profTitulaire->getId(), $request->request->get('_token'))) {
            $profTitulaireRepository->remove($profTitulaire, true);
        }

        return $this->redirectToRoute('app_prof_titulaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
