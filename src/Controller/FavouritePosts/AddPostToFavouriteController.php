<?php


namespace App\Controller\FavouritePosts;


use App\Entity\FavouritePost;
use App\Repository\FavouritePostRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddPostToFavouriteController extends AbstractController
{
    private PostRepository $postRepository;
    private FavouritePostRepository $favouritePostRepository;

    public function __construct(PostRepository $postRepository, FavouritePostRepository $favouritePostRepository)
    {
        $this->postRepository = $postRepository;
        $this->favouritePostRepository = $favouritePostRepository;
    }

    #[Route('/favourite/add/{id}', name: 'add_to_favourite', methods: ['GET'])]
    public function addToFavourite(int $id): Response
    {
        $user = $this->getUser();
        $post = $this->postRepository->find($id);

        $isFavourite = $this->favouritePostRepository->findOneBy([
            'post' => $post,
            'user' => $user
        ]);

        if (!$isFavourite) {
            $favouritePost = new FavouritePost();
            $favouritePost->setUser($user);
            $favouritePost->setPost($post);

            $this->favouritePostRepository->save($favouritePost);
        }

        return $this->redirectToRoute('index');
    }
}