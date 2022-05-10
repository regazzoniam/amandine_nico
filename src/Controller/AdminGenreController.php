<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\AccountType;
use App\Form\GenreType;
use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGenreController extends AbstractController
{
    public function __construct(private GenreRepository $genreRepository, private EntityManagerInterface $em, private PaginatorInterface $paginator) { }  
    
    #[Route('/admin/genre_all', name: 'app_admin_genre_all')]
    public function list(Request $request): Response
    {
        $qb = $this->genreRepository->getQbAll();
        $pagination = $this->paginator->paginate(
            $qb,
            $request->query->getInt('page',1),
            5
        );

        return $this->render('admin_genre/all.html.twig', [
            'pagination' => $pagination,
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

    #[Route('/admin/genre_edit/{slug}', name: 'app_admin_genre_edit')]
    public function edit($slug, Request $request): Response
    {
        $genreEntity = $this->genreRepository->findOneBy(['slug' => $slug]) ;

        $form = $this->createForm(GenreType::class, $genreEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_admin_genre_all');
        }

        return $this->render('admin_genre/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/genre_add', name: 'app_admin_genre_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(GenreType::class, new Genre());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_admin_genre_all');
        }

        return $this->render('admin_genre/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
}
