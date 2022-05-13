<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminForumController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private ForumRepository $forumRepository)
    {

    }

    //Vue All
    #[Route('/forum_all', name: 'app_admin_forum_all')]
    public function index(): Response
    {
        $forumEntities = $this->forumRepository->findAll();

        return $this->render('admin_forum/index.html.twig', [
            'forumEntities' => $forumEntities
        ]);
    }

    //Ajouter un nouveau forum
    #[Route('/forum_add', name: 'app_admin_forum_add')]
    public function add(Request $request):Response
    {
        $forum = new Forum();
        $formForum = $this->createForm(ForumType::class, $forum);
        $formForum->handleRequest($request);

        if($formForum->isSubmitted() && $formForum->isValid()){
            $forum->setCreatedAt(new \DateTime());
            $forum = $formForum->getData();
            $this->em->persist($forum);
            $this->em->flush();
            return $this->redirectToRoute('app_admin_forum_all');

        }

        return $this->render('admin_forum/new.html.twig', [
            'formForum' => $formForum->createView()
        ]);

    }

    //Supprimer un Forum
    #[Route('/forum_delete/{id}', name: 'app_admin_forum_delete')]
    public function delete($id) :Response
    {
        $forum = $this->forumRepository->findOneBy(['id' => $id]);
        $this->em->remove($forum);
        $this->em->flush();

        return $this->redirectToRoute('app_admin_forum_all');
    }

    //Editer un forum existant
    #[Route('/forum_edit/{id}', name: 'app_admin_forum_edit')]
    public function edit($id,Request $request) :Response
    {

        $forum = $this->forumRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('app_admin_forum_all');
        }

        return $this->render('admin_forum/edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/forum_details/{id}', name: 'app_admin_forum_details')]
    public function details($id)
    {
        $forumDetails =$this->forumRepository->findOneBy(['id' => $id]);

        return $this->render('admin_forum/details.html.twig',[
           'forumDetails' => $forumDetails
        ]);
    }


}