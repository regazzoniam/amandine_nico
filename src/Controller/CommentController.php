<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    public function __construct(private CommentRepository $commentRepository)
    {
        
    }
    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
