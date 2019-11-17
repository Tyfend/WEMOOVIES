<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_pannel")
     */
    public function showAdmin()
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }
}
