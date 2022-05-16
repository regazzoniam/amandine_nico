<?php

namespace App\Twig;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GameExtension extends AbstractExtension
{
    // comme dans un controller, on ajoute un gameRepository à notre function construct
    public function __construct(private GameRepository $gameRepository, private Environment $environment)
    {    
    }
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            // obtenir les derniers jeux sortis
            new TwigFunction('get_last_ten_games', [$this, 'getLastTenGames']),
            // obtenir les étoiles liées à la la note des jeux
            new TwigFunction('get_stars_for_game', [$this, 'getStarsForGame']),
        ];
    }

    public function getLastTenGames()
    {
        // fait appel à la fonction latestGames présente dans le gameRepository
        $gameEntities = $this->gameRepository->latestGames();
        return $gameEntities;
    }

    public function getStarsForGame(Game $game)
    {
        $totalNote = 0;
        $sumNote = 0;

        foreach($game->getComments() as $comment){
            if($comment->getNote() != null) {
                $totalNote++;
                $sumNote += $comment->getNote();
            }
        }
        if($totalNote == 0){
            return '<p>Aucune note<p>';
        }else{
            $noteAvg = $sumNote / $totalNote;
            // pour pouvoir utiliser la fonction render
            $html = $this->environment->render('game/_stars.html.twig', [
                'note' => (int)$noteAvg
            ]);
            return $html;
        }
    }

}
