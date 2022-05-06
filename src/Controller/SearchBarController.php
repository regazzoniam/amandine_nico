<?php

namespace App\Controller;

use App\Form\SearchBarType;
use App\Repository\GameRepository;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchBarController extends AbstractController
{
    #[Route('/search', name: 'app_search_bar')]
    public function index(Request $request, GameRepository $gameRepository): Response
    {

        $formSearch = $this->createForm(SearchBarType::class);
        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid()){
            //Permet de récupérer la valeur d'un seul champ d'un formulaire
            $value = $formSearch['searchValue']->getData();
             if ($value === null) {
                 return $this->redirectToRoute('app_game');
             }

             $existingGames = $gameRepository->findGameByApproxName($value);

            // si > 1 /jeux/recherche/$value
             if(count($existingGames) > 1){

                 //On retourne sur la vue de tous les jeux, mais tabGames cgange de valeur
                 // et retourne la variable existingGames qui contient la requète de recherche
                 return $this->render('game/index.html.twig', [
                     'tabGames' => $existingGames,
                 ]);
             }

            // si == 1 => rediectToRoute app_game_show + param
             if(count($existingGames) == 1 ){
                 return $this->redirectToRoute('app_game_show', [
                     'slug' => $existingGames[0]->getSlug()
                 ]);
//                 dd($existingGames);
             }

            // tester retour
            // si 0 == /jeux
            return $this->redirectToRoute('app_game');

        }

        return $this->render('search_bar/index.html.twig', [
            'formSearch' => $formSearch->createView(),
        ]);
    }

}
