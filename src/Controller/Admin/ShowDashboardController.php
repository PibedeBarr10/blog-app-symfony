<?php


namespace App\Controller\Admin;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowDashboardController extends AbstractController
{
    private PostRepository $postRepostiory;

    public function __construct(PostRepository $postRepostiory)
    {
        $this->postRepostiory = $postRepostiory;
    }

    #[Route('/admin/', name: 'dashboard', methods: ['GET'])]
    public function showPosts(): Response
    {
        $posts = $this->postRepostiory->findAll();

        return $this->render('admin/dashboard/index.html.twig', [
            'posts' => $posts
        ]);
    }
}