<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class PlaylistController extends AbstractController
{
    /**
     * @Route("/playlist", name="playlist_index", methods={"GET"})
     */
    public function index(PlaylistRepository $playlistRepository): Response
    {
        return $this->render('playlist/index.html.twig', [
            'playlists' => $playlistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/playlist/new", name="playlist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($playlist);
            $entityManager->flush();

            return $this->redirectToRoute('playlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlist/new.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/playlist/{id}", name="playlist_show", methods={"GET"})
     */
    public function show(Playlist $playlist): Response
    {
        return $this->render('playlist/show.html.twig', [
            'playlist' => $playlist,
        ]);
    }


    /**
     * @Route("/playlist/{id}/guess", name="playlist_titre_guess")
     */
    public function titreGuessPlaylist(Request $request, PlaylistRepository $playlistRepository, EntityManagerInterface $entityManager, Playlist $playlist): Response
    {
        $allSongs = $playlistRepository->findOneBy(['id' => $playlist->getId()]);

        $chansonsGiven = $allSongs->getChansons();


        $titles = '';
        for ($i = 0; $i <= count($chansonsGiven) - 1; $i++) {
            $titles .= $chansonsGiven[$i]->getTitre() . '-';

        }
        $titlesGiven = explode('-', $titles);
        $titlesClean = array_pop($titlesGiven);

        $titlesAnswers = $request->get('title');

        $false = array_diff($titlesGiven, $titlesAnswers);


        $result = (count($chansonsGiven)) - (count($false));


        $entityManager->persist($this->getUser()->setPoints($result));
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/playlist/{id}/edit", name="playlist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Playlist $playlist): Response
    {
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('playlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('playlist/edit.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/playlist/{id}/delete", name="playlist_delete", methods={"POST"})
     */
    public function delete(Request $request, Playlist $playlist): Response
    {
        if ($this->isCsrfTokenValid('delete'.$playlist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($playlist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('playlist_index', [], Response::HTTP_SEE_OTHER);
    }
}
