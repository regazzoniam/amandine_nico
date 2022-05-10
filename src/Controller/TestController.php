<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\PublisherType;
use App\Repository\AccountRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    private AccountRepository $accountRepository;
    private PaginatorInterface $paginator;

    public function __construct(AccountRepository $accountRepository,PaginatorInterface $paginator)
    {
        $this->accountRepository = $accountRepository;
        $this->paginator = $paginator;
    }

    #[Route('/test', name: 'app_test')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $qb = $this->accountRepository->getQbAll();
        $pagination = $this->paginator->paginate(
            // 1er argument : query builder
            $qb,
            // 2eme argument :  sur quel page on se trouve (1 : page par défaut)
            $request->query->getInt('page',1),
            // 3eme argument :nombre de resultats par page
            15
        );

        // $publisherEntity = new Publisher();
        // $form = $this->createForm(PublisherType::class, $publisherEntity);
        // //récupère contenu du formulaire, et fait le lien avec entité si form reliée à l'entitée
        // $form->handleRequest($request);

        // if($form->isSubmitted() && $form->isValid()){
        //     $publisherEntity->setCreatedAt(new DateTime());
        //     $em->persist($form->getData());
        //     $em->flush();
        //     dump($publisherEntity);
        // }

        // $user = $this->getUser();
        // dump($user);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            // 'form' => $form->createView(),
            'pagination' => $pagination
        ]);
    }
}
