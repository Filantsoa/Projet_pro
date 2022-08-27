<?php

namespace App\Controller;

use App\Entity\Displines;
use App\Form\DisplinesType;
use App\Repository\DisplinesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/displines")
 */
class DisplinesController extends AbstractController
{
    /**
     * @Route("/", name="app_displines_index", methods={"GET"})
     */
    public function index(DisplinesRepository $displinesRepository): Response
    {
        return $this->render('displines/index.html.twig', [
            'displines' => $displinesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_displines_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DisplinesRepository $displinesRepository): Response
    {
        $displine = new Displines();
        $form = $this->createForm(DisplinesType::class, $displine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $displinesRepository->add($displine, true);

            return $this->redirectToRoute('app_displines_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('displines/new.html.twig', [
            'displine' => $displine,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_displines_show", methods={"GET"})
     */
    public function show(Displines $displine): Response
    {
        return $this->render('displines/show.html.twig', [
            'displine' => $displine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_displines_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Displines $displine, DisplinesRepository $displinesRepository): Response
    {
        $form = $this->createForm(DisplinesType::class, $displine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $displinesRepository->add($displine, true);

            return $this->redirectToRoute('app_displines_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('displines/edit.html.twig', [
            'displine' => $displine,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_displines_delete", methods={"POST"})
     */
    public function delete(Request $request, Displines $displine, DisplinesRepository $displinesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$displine->getId(), $request->request->get('_token'))) {
            $displinesRepository->remove($displine, true);
        }

        return $this->redirectToRoute('app_displines_index', [], Response::HTTP_SEE_OTHER);
    }
}
