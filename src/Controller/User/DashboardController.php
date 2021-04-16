<?php


namespace App\Controller\User;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard', methods: ['GET', 'POST'])]
    public function dashboard(): Response
    {
        # $favourite_posts = $this->
        return $this->render('user_dashboard/index.html.twig');
    }
}