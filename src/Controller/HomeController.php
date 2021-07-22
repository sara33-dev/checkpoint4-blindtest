<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ChansonRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(UserRepository $userRepository, ChansonRepository $chansonRepository): Response
    {
       $users = $userRepository->findBy(array(), array('points' => 'DESC'));

       $chanson = $chansonRepository->findOneBy(array());

        return $this->render('home/index.html.twig', [
            'users'   => $users,
            'chanson' => $chanson,
        ]);
    }
}
