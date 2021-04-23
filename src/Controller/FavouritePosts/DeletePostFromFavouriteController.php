<?php


namespace App\Controller\FavouritePosts;


use App\Repository\FavouritePostRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePostFromFavouriteController extends AbstractController
{
    private FavouritePostRepository $favouritePostRepository;
    private PostRepository $postRepository;

    public function __construct(FavouritePostRepository $favouritePostRepository, PostRepository $postRepository)
    {
        $this->favouritePostRepository = $favouritePostRepository;
        $this->postRepository = $postRepository;
    }

    #[Route('/favourite/delete/{id}', name: 'delete_from_favourite', methods: ['DELETE'])]
    public function delete_from_favourite(int $id): Response
    {
        $post = $this->postRepository->find($id);

        if (!$post || !$post->getVisible()) {
            $this->addFlash('danger', 'Nie ma takiego posta');
            $this->redirectToRoute('favourite_posts');
        }

        $removedPost = $this->favouritePostRepository->findOneBy([
            'user' => $this->getUser(),
            'post' => $post
        ]);

        if (!$removedPost) {
            $this->addFlash('danger', 'Nie masz takiego posta w ulubionych');
            $this->redirectToRoute('favourite_posts');
        }

        $this->favouritePostRepository->remove($removedPost);

        $this->addFlash('success', 'Usunięto posta z ulubionych');
        return $this->redirectToRoute('favourite_posts');
    }
}