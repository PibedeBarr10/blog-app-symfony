<?php


namespace App\Controller\Comment;


use App\Entity\Comment;
use App\Form\AddCommentAnonymouslyFormType;
use App\Form\AddCommentByUserFormType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCommentController extends AbstractController
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

    #[Route('/post/{id}/comment/add', name: 'add_comment', methods: ['GET', 'POST'])]
    public function add_comment(Request $request, int $id): Response
    {
        $post = $this->postRepository->find($id);

        if (!$post || !$post->getVisible()) {
            $this->addFlash('danger', 'Nie ma takiego posta');
            return $this->redirectToRoute('index');
        }

        $comment = new Comment();

        if ($this->getUser()) {
            $form = $this->createForm(AddCommentByUserFormType::class, $comment);

            $comment->setAuthor($this->getUser()->getUsername());
            $comment->setCreatedByUser(true);
        } else {
            $form = $this->createForm(AddCommentAnonymouslyFormType::class, $comment);
            $comment->setCreatedByUser(false);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);

            $this->commentRepository->save($comment);

            $this->addFlash('success', 'Dodano komentarz');
            return $this->redirectToRoute('show_post', [
                'id' => $id
            ]);
        }

        return $this->render('comment/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}