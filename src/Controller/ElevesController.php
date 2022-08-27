<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Form\ElevesType;
use App\Repository\ElevesRepository;
use App\Entity\Displines;
use App\Form\DisplinesType;
use App\Repository\DisplinesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/eleves")
 */
class ElevesController extends AbstractController
{
    /**
     * @Route("/", name="app_eleves_index", methods={"GET"})
     */
    public function index(
        Request $request, 
        ElevesRepository $elevesRepository, 
        PaginatorInterface $paginator
    ): Response
    {
        $donnes = $this->getDoctrine()->getRepository(Eleves::class)->findBy([],['matricule' => 'ASC']);

        // $queryBuilder = $profTitulaireRepository->getWithSerchQueryBuilder($q);
        $eleves = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('eleves/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }

    /**
     * @Route("/new", name="app_eleves_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ElevesRepository $elevesRepository, PaginatorInterface $paginator): Response
    {
        $elefe = new Eleves();
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elevesRepository->add($elefe, true);

            $this->addFlash('success', 'Eleve créé ! Savoir c\'est pouvoir !');
            return $this->redirectToRoute('app_eleves_new', [], Response::HTTP_SEE_OTHER);
        }

        // afichage
        $donnes = $this->getDoctrine()->getRepository(Eleves::class)->findBy([],['id' => 'DESC']);

        // $queryBuilder = $profTitulaireRepository->getWithSerchQueryBuilder($q);
        $eleves = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1),
            5
        );

        return $this->renderForm('eleves/new.html.twig', [
            'eleves' => $eleves,
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_eleves_show", methods={"GET"})
     */
    public function show(
        Eleves $elefe,
        DisplinesRepository $displine,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $donnes = $this->getDoctrine()->getRepository(Eleves::class)->findBy([],['matricule' => 'ASC']);

        // $queryBuilder = $profTitulaireRepository->getWithSerchQueryBuilder($q);
        $eleves = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('eleves/show.html.twig', [
            'elefe' => $elefe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_eleves_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Eleves $elefe, ElevesRepository $elevesRepository): Response
    {
        $form = $this->createForm(ElevesType::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elevesRepository->add($elefe, true);

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleves/edit.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_eleves_delete", methods={"POST"})
     */
    public function delete(Request $request, Eleves $elefe, ElevesRepository $elevesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$elefe->getId(), $request->request->get('_token'))) {
            $elevesRepository->remove($elefe, true);
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }
}
