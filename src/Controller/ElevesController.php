<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Form\ElevesType;
use App\Repository\ElevesRepository;
use App\Entity\Displines;
use App\Form\DisplinesType;
use App\Form\SearchType;
use App\Repository\DisplinesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/eleves")
 */
class ElevesController extends AbstractController
{
    /**
     * @Route("/", name="app_eleves_index", methods={"GET", "POST"})
     */
    public function index(
        Request $request, 
        ElevesRepository $elevesRepository, 
        PaginatorInterface $paginator
    ): Response
    {

        // $searchForm = $this->createForm(SearchType::class);
        // $searchForm->handleRequest($request);

        // if ($searchForm->isSubmitted() && $searchForm->isValid()) {
        //     $matricule = $searchForm->getData()->getMatricule();
        //     $donnes = $repo->search($matricule);

        //     return $this->redirectToRoute('app_eleves_index');

        //     $donnes = $this->getDoctrine()->getRepository(Eleves::class)->findBy([],['matricule' => 'DESC']);
        // }else{
        //     $donnes = $this->getDoctrine()->getRepository(Eleves::class)->findBy([],['matricule' => 'ASC']);
        // }

        $donnes = $this->getDoctrine()->getRepository(Eleves::class)->findBy([],['matricule' => 'ASC']);
        // $queryBuilder = $profTitulaireRepository->getWithSerchQueryBuilder($q);
        $eleves = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1),
            5
        );

        
        return $this->render('eleves/index.html.twig', [
            'eleves' => $eleves,
            // 'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/pdf", name="app_eleves_pdf")
     */
    public function myPdf(Eleves $eleve)
    {
        // pdf create
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // $eleve = $elevesRepository->findAll();

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('eleves/mypdf.html.twig', [
            'eleve' => $eleve,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        // $dompdf->stream("mypdf.pdf", [
        //     "Attachment" => false,
        // ]);

        $output = $dompdf->output();

        $publicDirectory = $this->getParameter('brochures_directory');

        $pdfFilepath = $publicDirectory . '/'.$eleve->getNom().' '.$eleve->getPrenom() .'.pdf';

        file_put_contents($pdfFilepath, $output);
        
        $this->addFlash('successPdf', 'Votre PDF bien Enregistre dans votre fichiet Public/pdf !');
        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        // return new Response("The pdf file ");
        // return $this->renderForm('eleves/mypdf.html.twig', [
        //     'eleves' => $eleve,
        // ]);
        
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
     * @Route("/{id}", name="app_eleves_show", methods={"GET", "POST"})
     */
    public function show(Eleves $elefe, Request $request, DisplinesRepository $displinesRepository, ElevesRepository $elevesRepository, PaginatorInterface $paginator): Response
    { 
        // dd($form);

        $displine = new Displines();
        $formDispline = $this->createForm(DisplinesType::class, $displine);
        $formDispline->handleRequest($request);

        // $this->entityManager = $entityManage;

        if ($formDispline->isSubmitted() && $formDispline->isValid()) {
            $displine->setEleves($elefe);
            $displine->setDate(new \DateTime('now'));

            // $this->entityManager->persist($displine);
            // $this->entityManager->flush();
            $displinesRepository->add($displine, true);
            $this->addFlash('message', 'Dipline bien enregistre !');
            return $this->redirectToRoute('app_eleves_show', ['id' => $elefe->getId()], Response::HTTP_SEE_OTHER);
        }

       
        return $this->render('eleves/show.html.twig', [
            'elefe' => $elefe,
            'formDispline' => $formDispline->createView(),
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
