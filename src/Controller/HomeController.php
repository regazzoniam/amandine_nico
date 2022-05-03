<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private GameRepository $gameRepository, private CommentRepository $commentRepository) { }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $latestGames = $this->gameRepository->latestGames();
        dump($latestGames);
        $latestComments = $this->commentRepository->latestComments();

        return $this->render('home/index.html.twig', [
            'latestGamesArray' => $latestGames,
            'latestCommentsArray' => $latestComments,
        ]);
    }



}
