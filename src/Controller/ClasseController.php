<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/classe")
 */
class ClasseController extends AbstractController
{
    /**
     * @Route("/", name="app_classe_index", methods={"GET"})
     */
    public function index(Request $request, ClasseRepository $classeRepository, PaginatorInterface $paginator): Response
    {

        $donnes = $this->getDoctrine()->getRepository(Classe::class)->findBy([],['nomClasse' => 'desc']);

        // $queryBuilder = $profTitulaireRepository->getWithSerchQueryBuilder($q);
        $classe = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('classe/index.html.twig', [
            'classes' => $classe,
        ]);
    }

    /**
     * @Route("/new", name="app_classe_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ClasseRepository $classeRepository): Response
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeRepository->add($classe, true);

            return $this->redirectToRoute('app_classe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classe/new.html.twig', [
            'classe' => $classe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_classe_show", methods={"GET"})
     */
    public function show(Classe $classe): Response
    {
        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_classe_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Classe $classe, ClasseRepository $classeRepository): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeRepository->add($classe, true);

            return $this->redirectToRoute('app_classe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classe/edit.html.twig', [
            'classe' => $classe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_classe_delete", methods={"POST"})
     */
    public function delete(Request $request, Classe $classe, ClasseRepository $classeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classe->getId(), $request->request->get('_token'))) {
            $classeRepository->remove($classe, true);
        }

        return $this->redirectToRoute('app_classe_index', [], Response::HTTP_SEE_OTHER);
    }
}
