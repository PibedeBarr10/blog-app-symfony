<?php


namespace App\Controller\Post;


use App\Repository\FavouritePostRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowAllPostsController extends AbstractController
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

    #[Route('/', name: 'index', methods: ['GET'])]
    public function showPosts(): Response
    {
        $posts = $this->postRepostiory->findBy([
            'visible' => true
        ]);

        if (!$this->getUser()) {
            return $this->render('post/index.html.twig', [
                'posts' => $posts
            ]);
        }

        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('dashboard');
        }

        $likedPosts = $this->likeRepository->postsLikedByUser($this->getUser());
        $favouritePosts = $this->favouritePostRepository->favouriteUserPosts($this->getUser());

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'likedPosts' => $likedPosts,
            'favouritePosts' => $favouritePosts
        ]);
    }
}