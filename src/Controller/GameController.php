<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    public function __construct(private GameRepository $gameRepository) { }

    #[Route('/jeux', name: 'app_game')]
    public function allGames(): Response
    {
        $games = $this->gameRepository->findAll();

        return $this->render('game/index.html.twig', [
            'tabGames' => $games,
        ]);
    }

    #[Route('/jeux/{slug}', name: 'slug_app_game')]
    public function OneGame($slug): Response
    {
        $gameEntity = $this->gameRepository->find($slug);
        dump($gameEntity);

        return $this->render('game/index.html.twig', [
            'gameEntity' => $gameEntity,
        ]);
    }
}
