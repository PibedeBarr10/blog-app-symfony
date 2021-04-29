<?php


namespace App\Controller\Admin\Post;


use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowPostAsAdminController extends AbstractController
{
    private PostRepository $postRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        PostRepository $postRepository,
        CommentRepository $commentRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route('/admin/post/{id}', name: 'show_post_as_admin', methods: ['GET'])]
    public function showPost(int $id): Response
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            $this->addFlash('danger', 'Nie ma takiego posta!');
            return $this->redirectToRoute('index');
        }

        $comments = $this->commentRepository->findBy([
            'post' => $post
        ]);

        return $this->render('post/post.html.twig', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}