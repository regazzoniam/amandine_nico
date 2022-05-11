<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Game;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GameController extends AbstractController
{
    public function __construct(private GameRepository $gameRepository, private CommentRepository $commentRepository) { }

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
    public function oneGame($slug, EntityManagerInterface $em, Request $request): Response
    {
        dump($slug);
        $getGameDetails = $this->gameRepository->getGameWithRelations($slug);
        dump($getGameDetails);

        //Afficher les jeux en relation avec le genre
        $relatedGame = $this->gameRepository->getRelatedGames($getGameDetails);
        dump($relatedGame);



        $user = $this->getUser();
        $gameEntity = $this->gameRepository->findOneBy(['slug' => $slug]);

        $commentEntity = $this->commentRepository->findOneByUserAndGame($user, $gameEntity);
        dump($commentEntity);


        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newComment = $form->getData();
            $newComment->setUpVotes(0);
            $newComment->setDownVotes(0);
            $newComment->setAccount($user);
            $newComment->setGame($gameEntity);
            $newComment->setCreatedAt( new \DateTime());
            $em->persist($newComment);
            $em->flush();
            return $this->redirectToRoute('app_game_show',['slug' =>$slug]);
        }


        return $this->render('game/show.html.twig', [
            'game' => $getGameDetails,
            'gameByGenre' => $relatedGame,
            'commentEntity' =>$commentEntity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/jeux/{slug}/commentaires', name: 'app_game_comments')]
    public function allGameComments($slug): Response
    {
        $gameWithAllComments = $this->gameRepository->getGameWithRelations($slug, false);
        dump($gameWithAllComments);



        return $this->render('comment/comments.html.twig', [
            'game' => $gameWithAllComments,
        ]);
    }





}
