<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    public function __construct(private ForumRepository $forumRepository)
    { }

    // Voir tous les forums
    #[Route('/forum_all', name: 'app_forum_all')]
    public function index(): Response
    {
        $forums = $this->forumRepository->findAll();
        return $this->render('forum/index.html.twig', [
            'forums' => $forums,
        ]);
    }

    //voir en détails un forum
    #[Route('/forum_details/{id}', name: 'app_forum_details')]
    public function details($id) :Response
    {
        $forum = $this->forumRepository->findOneBy(['id' => $id]);

        return $this->render('forum/details.html.twig', [
            'forum' => $forum
        ]);
    }
}
