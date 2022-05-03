<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private GameRepository $gameRepository) { }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $latestGames = $this->gameRepository->latestGames();
        dump($latestGames);

        return $this->render('home/index.html.twig', [
            'latestGamesArray' => $latestGames,
        ]);
    }



}
