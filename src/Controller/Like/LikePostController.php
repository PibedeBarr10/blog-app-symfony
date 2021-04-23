<?php


namespace App\Controller\Like;


use App\Entity\Like;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikePostController extends AbstractController
{
    private LikeRepository $likeRepository;
    private PostRepository $postRepository;

    public function __construct(LikeRepository $likeRepository, PostRepository $postRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->postRepository = $postRepository;
    }

    #[Route('/like/{id}', name: 'like_post', methods: ['GET'])]
    public function likePost(int $id): Response
    {
        $user = $this->getUser();
        $post = $this->postRepository->find($id);

        if (!$post || !$post->getVisible()) {
            $this->addFlash('danger', 'Nie ma takiego posta!');
            return $this->redirectToRoute('index');
        }

        $like = $this->likeRepository->findOneBy([
            'post' => $post,
            'user' => $user
        ]);

        if ($like) {
            $this->likeRepository->remove($like);
            return $this->redirectToRoute('index');
        }

        $like = new Like();
        $like->setPost($post);
        $like->setUser($user);

        $this->likeRepository->save($like);

        return $this->redirectToRoute('index');
    }
}