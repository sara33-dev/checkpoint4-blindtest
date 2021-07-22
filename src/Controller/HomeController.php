<?php

namespace App\Controller;

use App\Repository\PlaylistRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(UserRepository $userRepository, PlaylistRepository $playlistRepository): Response
    {
       $users = $userRepository->findBy(array(), array('points' => 'DESC'));

       $chansonsToGuess = $playlistRepository->findAll();

        return $this->render('home/index.html.twig', [
            'users'   => $users,
            'chansonsToGuess' => $chansonsToGuess,
        ]);
    }

    /**
     * @Route("/guess", name="titre_guess")
     */
    public function titreGuess(Request $request, PlaylistRepository $playlistRepository, EntityManagerInterface $entityManager): Response
    {
        $allSongs = $playlistRepository->findAll();
        $chansonsGiven = $allSongs[0]->getChansons();

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
}
