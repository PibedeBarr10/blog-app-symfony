<?php


namespace App\Controller\Post;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowPostController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route('/post/{id}', name: 'show_post', methods: ['GET'])]
    public function showPost(int $id): Response
    {
        $post = $this->postRepository->find($id);

        return $this->render('post/post.html.twig', [
            'post' => $post
        ]);
    }
}