<?php


namespace App\Controller\FavouritePosts;


use App\Repository\FavouritePostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowFavoutivePostsController extends AbstractController
{
    private FavouritePostRepository $favouritePostRepository;

    public function __construct(FavouritePostRepository $favouritePostRepository)
    {
        $this->favouritePostRepository = $favouritePostRepository;
    }

    #[Route('/favourite', name: 'favourite_posts', methods: ['GET'])]
    public function favourite_posts(): Response
    {
        $favouritePosts = $this->favouritePostRepository->getUserFavouritePosts($this->getUser());

        return $this->render('favouritePost/index.html.twig', [
            'favouritePosts' => $favouritePosts
        ]);
    }
}