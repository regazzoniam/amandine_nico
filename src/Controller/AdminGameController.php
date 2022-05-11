<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGameController extends AbstractController
{
    public function __construct(private GameRepository $gameRepository, private EntityManagerInterface $em, private PaginatorInterface $paginator)
    { }

    // voir tous les jeux
    #[Route('/admin/game_all', name: 'app_admin_game_all')]
    public function list(Request $request): Response
    {
        $qb = $this->gameRepository->getQbAll();
        $pagination = $this->paginator->paginate(
            $qb,
            $request->query->getInt('page',1),
            5
        );

        return $this->render('admin_game/all.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    // voir le détail d'un jeu
    #[Route('/admin/game/{slug}', name: 'app_admin_game_details')]
    public function details($slug): Response
    {
        $gameEntity = $this->gameRepository->findOneBy(['slug' => $slug]) ;
        dump($gameEntity);
        
        return $this->render('admin_game/details.html.twig', [
            'game' => $gameEntity,
        ]);
    }

    // Update un pays
    #[Route('/admin/game_edit/{slug}', name: 'app_admin_game_edit')]
    public function edit($slug, Request $request): Response
    {
        $gameEntity = $this->gameRepository->findOneBy(['slug' => $slug]) ;
        $form = $this->createForm(GameType::class, $gameEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('app_admin_game_all');
        }
        return $this->render('admin_game/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    // Supprimer un jeu
    #[Route('/admin/game_delete/{slug}', name: 'app_admin_game_delete')]
    public function delete($slug): Response
    {
        $game = $this->gameRepository->findOneBy(['slug' => $slug]) ;
        $this->em->remove($game);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_game_all');
    }

    // ajouter un jeu
    #[Route('/admin/game_add', name: 'app_admin_game_add')]
    public function add(Request $request): Response
    {

        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $game->setPublishedAt(new DateTime());
            // dd($game);
            $this->em->persist($game);
            $this->em->flush();
            return $this->redirectToRoute('app_admin_game_all');
        }

        return $this->render('admin_game/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
