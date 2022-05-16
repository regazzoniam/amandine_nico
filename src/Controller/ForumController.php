<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    public function __construct(private ForumRepository $forumRepository, private PaginatorInterface $paginator)
    { }

    // Voir tous les forums
    #[Route('/forum_all', name: 'app_forum_all')]
    public function index(Request $request): Response
    {
        $qb = $this->forumRepository->getQbAll();
        $pagination = $this->paginator->paginate(
            $qb,
            $request->query->getInt('page',1),
            5
        );
        // $forums = $this->forumRepository->findAll();

        return $this->render('forum/index.html.twig', [
            // 'forums' => $forums,
            'pagination' => $pagination,
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
