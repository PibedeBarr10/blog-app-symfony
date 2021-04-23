<?php


namespace App\Controller\Admin\Post;


use App\Form\EditPostFormType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditPostController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route('/admin/post/edit/{id}', name: 'edit_post', methods: ['GET', 'POST'])]
    public function editPost(Request $request, int $id): Response
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            $this->addFlash('danger', 'Nie znaleziono takiego posta');
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->createForm(EditPostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postRepository->save($post);

            $this->addFlash('success', 'Zaaktualizowano posta');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);
    }
}