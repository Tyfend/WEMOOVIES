<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig', []);
    }

    /**
     * @Route("/signup", name="security_signup")
     */
    public function registration(ObjectManager $manager, Request $request, UserPasswordEncoderInterface $encode)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encode->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            if(!$user->getRoles()) {
                $user->setRoles(['ROLE_USER']);
            }

            $manager->persist($user);
            $manager->flush();
            
            return $this->redirectToRoute('security_login');
        }
 
        return $this->render('security/registration.html.twig', [
            'form' =>  $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */

    public function logout(){
    }
}
