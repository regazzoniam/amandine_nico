<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\GenreType;
use App\Form\PublisherType;
use App\Repository\CountryRepository;
use App\Repository\PublisherRepository;
use ContainerPZ2eEIT\getAdminPublisherControllerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminPublisherController extends AbstractController
{

    public function __construct(private PublisherRepository $publisherRepository, private EntityManagerInterface $em)
    {

    }

    #[Route('/publisher_all', name: 'app_admin_publisher_all')]
    public function list(): Response
    {
        $publishers = $this->publisherRepository->findAll();
        dump($publishers);

        return $this->render('admin_publisher/all.html.twig', [
            'publishers' => $publishers
        ]);
    }


    #[Route('/publisher/{slug}', name: 'app_admin_publisher_details')]
    public function details($slug):Response
    {
        $publisher = $this->publisherRepository->findOneBy(['slug' => $slug]);
        dump($publisher);

        return $this->render('admin_publisher/details.html.twig', [
            'publisher' => $publisher
        ]);
    }


    #[Route('/publisher_delete/{slug}', name: 'app_admin_publisher_delete')]
    public function delete($slug)
    {
        $publisher = $this->publisherRepository->findOneBy(['slug' => $slug]);
        $this->em->remove($publisher);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_publisher_all');


    }

    #[Route('/publisher_add', name: 'app_admin_publisher_add')]
    public function add(Request $request)
    {
        $form = $this->createForm(PublisherType::class, new Publisher());
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $publisher = $form->getData();
            $publisher->setCreatedAt(new \DateTime());
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->redirectToRoute('app_admin_publisher_all');
        }

        return $this->render('admin_publisher/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/publisher_add', name: 'app_admin_publisher_add')]
    public function edit($slug, Request $request) :Response {
        $publisherEntity = $this->publisherRepository->findOneBy(['slug' => $slug]);

        $form = $this->createForm(PublisherType::class, $publisherEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('app_admin_publisher_all');
        }

//        return $this->

    }







}
