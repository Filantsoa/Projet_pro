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
use Dompdf\Dompdf;
use Dompdf\Options;

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
     * @Route("/{id}/pdf", name="app_classes_pdf")
     */
    public function myPdfClasse(Classe $classe)
    {
        // pdf create
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // $classe = $classeRepository->findAll();

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('classe/listePdf.html.twig', [
            'classe' => $classe,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false,
        ]);

        // $output = $dompdf->output();

        // $publicDirectory = $this->getParameter('brochures_directory');

        // $pdfFilepath = $publicDirectory . '/'.$classe->getnomClasse().' '.$classe->getIndice() . '.pdf';

        // file_put_contents($pdfFilepath, $output);
        
        // $this->addFlash('successPdf', 'Votre PDF bien Enregistre dans votre fichiet Public/pdf !');
        // return $this->redirectToRoute('app_classe_index', [], Response::HTTP_SEE_OTHER);        
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

            $this->addFlash('success', 'Classe créé ! Savoir c\'est pouvoir !');
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

            $this->addFlash('success', 'Classe modifie ! Savoir c\'est pouvoir !');
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
            $this->addFlash('suppr', 'Classe suprimer ! Savoir c\'est pouvoir !');
            $classeRepository->remove($classe, true);
        }

        return $this->redirectToRoute('app_classe_index', [], Response::HTTP_SEE_OTHER);
    }
}
