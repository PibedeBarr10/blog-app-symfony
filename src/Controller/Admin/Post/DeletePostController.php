<?php


namespace App\Controller\Admin\Post;


use App\Repository\CommentRepository;
use App\Repository\FavouritePostRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePostController extends AbstractController
{
    private PostRepository $postRepository;
    private LikeRepository $likeRepository;
    private FavouritePostRepository $favouritePostRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        PostRepository $postRepository,
        LikeRepository $likeRepository,
        FavouritePostRepository $favouritePostRepository,
        CommentRepository $commentRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->likeRepository = $likeRepository;
        $this->favouritePostRepository = $favouritePostRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route('/admin/post/delete/{id}', name: 'delete_post', methods: ['DELETE'])]
    public function delete_post(int $id): Response
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            $this->addFlash('danger', 'Nie znaleziono takiego posta');
            return $this->redirectToRoute('dashboard');
        }

        $this->likeRepository->removeAllByPostId($post);
        $this->favouritePostRepository->removeAllByPostId($post);
        $this->commentRepository->removeAllByPostId($post);

        $this->postRepository->remove($post);

        $this->addFlash('success', 'Usunięto posta');
        return $this->redirectToRoute('dashboard');
    }
}