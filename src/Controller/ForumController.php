<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    public function __construct(private ForumRepository $forumRepository){

    }
    #[Route('/forum', name: 'app_forum_all')]
    public function index(): Response
    {
        $forums = $this->forumRepository->findAll();

        return $this->render('forum/index.html.twig', [
            'forums' => $forums
        ]);
    }

    #[Route('/forum_details/{id}', name: 'app_forum_details')]
    public function details($id)
    {
        $forumDetails = $this->forumRepository->find($id);

        return $this->render('topic/details.html.twig', [
            'forumDetails' => $forumDetails,
        ]);
    }
}
