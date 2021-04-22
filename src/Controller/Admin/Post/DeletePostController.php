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
    ) {
        $this->postRepository = $postRepository;
        $this->likeRepository = $likeRepository;
        $this->favouritePostRepository = $favouritePostRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route('/admin/post/delete/{id}', name: 'delete_post', methods: ['DELETE'])]
    public function delete_post(int $id): Response
    {
        if(!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $this->addFlash('danger', 'Nie masz uprawnień');
            return $this->redirectToRoute('index');
        }

        $post = $this->postRepository->find($id);

        if (!$post) {
            $this->addFlash('danger', 'Nie znaleziono takiego posta');
            return $this->redirectToRoute('dashboard');
        }

        $likes = $this->likeRepository->findBy([
            'post' => $post
        ]);

        $favPosts = $this->favouritePostRepository->findBy([
            'post' => $post
        ]);

        $comments = $this->commentRepository->findBy([
            'post' => $post
        ]);

        foreach ($likes as $like) {
            $this->likeRepository->remove($like);
        }

        foreach ($favPosts as $fav) {
            $this->favouritePostRepository->remove($fav);
        }

        foreach ($comments as $comment) {
            $this->commentRepository->remove($comment);
        }

        $this->postRepository->remove($post);

        $this->addFlash('success', 'Usunięto posta');
        return $this->redirectToRoute('dashboard');
    }
}