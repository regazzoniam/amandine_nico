<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private GameRepository $gameRepository, private CommentRepository $commentRepository) { }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // jeux - dernières sorties
        $latestGames = $this->gameRepository->latestGames();

        // commentaires - derniers commentaires
        $latestComments = $this->commentRepository->latestComments();

        // jeux - les plus joués
        $mostPlayedGames = $this->gameRepository->getMostPlayedGames();

        //jeux - les plus achetés
        $mostBoughtGames = $this->gameRepository->getMostBoughtGames();

        return $this->render('home/index.html.twig', [
            'latestGamesArray' => $latestGames,
            'latestCommentsArray' => $latestComments,
            'mostPlayedGamesArray' => $mostPlayedGames,
            'mostBoughtGamesArray' => $mostBoughtGames,
        ]);
    }



}
