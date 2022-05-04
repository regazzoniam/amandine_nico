<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/jeux/{slug}', name: 'app_game_show')]
    public function oneGame($slug): Response
    {
        dump($slug);
        $getGameDetails = $this->gameRepository->getOneGame($slug);
        dump($getGameDetails);

        return $this->render('game/show.html.twig', [
            'game' => $getGameDetails,
        ]);
    }
}
