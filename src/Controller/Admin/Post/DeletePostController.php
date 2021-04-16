<?php


namespace App\Controller\Admin\Post;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePostController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route('/admin/post/delete/{id}', name: 'delete_post', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            $this->addFlash('danger', 'Nie znaleziono takiego postu');
            return $this->redirectToRoute('index');
        }

        $this->postRepository->remove($post);

        $this->addFlash('success', 'Usunięto posta');
        return $this->redirectToRoute('index');
    }
}