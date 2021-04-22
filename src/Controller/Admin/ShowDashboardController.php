<?php


namespace App\Controller\Admin;


use App\Repository\FavouritePostRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowDashboardController extends AbstractController
{
    private PostRepository $postRepostiory;
    private LikeRepository $likeRepository;
    private FavouritePostRepository $favouritePostRepository;

    public function __construct(
        PostRepository $postRepostiory,
        LikeRepository $likeRepository,
        FavouritePostRepository $favouritePostRepository
    ) {
        $this->postRepostiory = $postRepostiory;
        $this->likeRepository = $likeRepository;
        $this->favouritePostRepository = $favouritePostRepository;
    }

    #[Route('/admin/posts/', name: 'dashboard', methods: ['GET'])]
    public function showPosts(): Response
    {
        $posts = $this->postRepostiory->findAll();

        return $this->render('dashboard/index.html.twig', [
            'posts' => $posts
        ]);
    }
}