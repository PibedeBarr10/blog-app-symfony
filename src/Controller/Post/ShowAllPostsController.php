<?php


namespace App\Controller\Post;


use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowAllPostsController extends AbstractController
{
    private PostRepository $postRepostiory;
    private LikeRepository $likeRepository;

    public function __construct(PostRepository $postRepostiory, LikeRepository $likeRepository)
    {
        $this->postRepostiory = $postRepostiory;
        $this->likeRepository = $likeRepository;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function showPosts(): Response
    {
        $posts = $this->postRepostiory->findAll();

        $likedPosts = $this->likeRepository->isLikedByUser($this->getUser());

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'likedPosts' => $likedPosts
        ]);
    }
}