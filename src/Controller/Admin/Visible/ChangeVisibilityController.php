<?php


namespace App\Controller\Admin\Visible;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeVisibilityController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route('/admin/changeVisibility/{id}', name: 'change_visibility', methods: ['GET'])]
    public function changeVisibility(int $id): Response
    {
        $post = $this->postRepository->find($id);

        if ($post->getVisible()) {
            $post->setVisible(false);
        } else {
            $post->setVisible(true);
        }

        $this->postRepository->save($post);

        $this->addFlash('success', 'Zmieniono widoczność');
        return $this->redirectToRoute('dashboard');
    }
}