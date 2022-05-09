<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGenreController extends AbstractController
{
    public function __construct(private GenreRepository $genreRepository, private EntityManagerInterface $em) { }  
    
    #[Route('/admin/genre_all', name: 'app_admin_genre_all')]
    public function list(): Response
    {
        $genres = $this->genreRepository->findAll() ;
        dump($genres);

        return $this->render('admin_genre/all.html.twig', [
            'genres' => $genres,
        ]);
    }
    #[Route('/admin/genre/{slug}', name: 'app_admin_genre_details')]
    public function details($slug): Response
    {
        $genreEntity = $this->genreRepository->findOneBy(['slug' => $slug]) ;
        dump($genreEntity);
        
        return $this->render('admin_genre/details.html.twig', [
            'genre' => $genreEntity,
        ]);
    }

    #[Route('/admin/genre_delete/{slug}', name: 'app_admin_genre_delete')]
    public function delete($slug): Response
    {
        $genreEntity = $this->genreRepository->findOneBy(['slug' => $slug]) ;
        $this->em->remove($genreEntity);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_genre_all');
    }
    
}
