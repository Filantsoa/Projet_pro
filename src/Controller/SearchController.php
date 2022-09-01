<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Search;
use App\Entity\Eleves;
use App\Repository\ElevesRepository;
use App\Form\SearchType;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(ElevesRepository $repo, Request $request): Response
    {

        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $matricule = $searchForm->getData()->getMatricule();
            $donnes = $repo->search($matricule);

            return $this->redirectToRoute('app_search');
        }
        return $this->render('search/index.html.twig', [
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * @Route("/result", name="search_result")
     */
    public function searchBar(Request $request)
    {
        $search = new Search();
        $form = $this->createFormBuilder(null)
            ->add('query', TextType::class)
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
                ])
            ->getForm();
        
        $form->handleRequest($request);

        $eleves = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $query = $search->getQuery();
            if ($query) {
                $eleves = $this->getDoctrine()->getRepository(Eleves::class)->findBy(['matricule' => $query]);
            }
            // else {
            //     $eleves = $this->getDoctrine()->getRepository(Eleves::class)->findAll();
            // }
        }
        return $this->render('search/result.html.twig', [
            'form' => $form->createView(),
            'eleves' => $eleves,
        ]);

    }
}
