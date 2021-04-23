<?php


namespace App\Controller\Admin\Post;


use App\Entity\Post;
use App\Form\CreatePostFormType;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatePostController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    #[Route('/admin/post/create', name: 'create_post', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $post = new Post();

        $form = $this->createForm(CreatePostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreationDate(new DateTimeImmutable());
            $post->setVisible(true);

            $this->postRepository->save($post);

            $this->addFlash('success', 'Utworzono nowego posta');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}