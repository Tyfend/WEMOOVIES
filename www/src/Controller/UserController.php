<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Method show profil user page
     * 
     * @Route("/profil", name="user_profil")
     */
    public function index(UserRepository $repo, Request $request)
    {

        // dd($repo);
        // $user = new User();
        // $mail = $user->getEmail();
        // dd($mail);
        return $this->render('user/index.html.twig', [
        ]);
    }

    
}
