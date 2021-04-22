<?php


namespace App\Controller\Visible;


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

    #[Route('/changeVisibility/{id}', name: 'change_visibility', methods: ['GET'])]
    public function changeVisibility(int $id): Response
    {
        if(!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $this->addFlash('danger', 'Nie masz uprawnień');
            return $this->redirectToRoute('index');
        }

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