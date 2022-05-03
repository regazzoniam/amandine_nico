<?php

namespace App\Controller;

use App\Repository\PublisherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublisherController extends AbstractController
{
    public function __construct(private PublisherRepository $publisherRepository)
    {
        $this->publisherRepository = $publisherRepository;
    }

    #[Route('/editeur', name: 'app_publisher')]
    public function allPublishers(): Response
    {
        $publishers = $this->publisherRepository->findAll();

        return $this->render('publisher/index.html.twig', [
            'publishers' => $publishers,
        ]);
    }
}
