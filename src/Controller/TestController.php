<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\PublisherType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $publisherEntity = new Publisher();
        $form = $this->createForm(PublisherType::class, $publisherEntity);
        //récupère contenu du formulaire, et fait le lien avec entité si form reliée à l'entitée
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $publisherEntity->setCreatedAt(new DateTime());
            $em->persist($form->getData());
            $em->flush;
            dump($publisherEntity);
        }

        $user = $this->getUser();
        dump($user);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'form' => $form->createView()
        ]);
    }
}
