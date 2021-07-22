<?php

namespace App\Controller;

use App\Entity\Chanson;
use App\Form\ChansonType;
use App\Repository\ChansonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chanson")
 */
class ChansonController extends AbstractController
{
    /**
     * @Route("/", name="chanson_index", methods={"GET"})
     */
    public function index(ChansonRepository $chansonRepository): Response
    {
        return $this->render('chanson/index.html.twig', [
            'chansons' => $chansonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="chanson_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chanson = new Chanson();
        $form = $this->createForm(ChansonType::class, $chanson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chanson);
            $entityManager->flush();

            return $this->redirectToRoute('playlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chanson/new.html.twig', [
            'chanson' => $chanson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chanson_show", methods={"GET"})
     */
    public function show(Chanson $chanson): Response
    {
        return $this->render('chanson/show.html.twig', [
            'chanson' => $chanson,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chanson_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chanson $chanson): Response
    {
        $form = $this->createForm(ChansonType::class, $chanson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chanson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chanson/edit.html.twig', [
            'chanson' => $chanson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chanson_delete", methods={"POST"})
     */
    public function delete(Request $request, Chanson $chanson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chanson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chanson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chanson_index', [], Response::HTTP_SEE_OTHER);
    }
}
