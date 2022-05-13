<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\ForumRepository;
use App\Repository\MessageRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{

    public function __construct(private TopicRepository $topicRepository, private ForumRepository $forumRepository, private EntityManagerInterface $em, private MessageRepository $messageRepository)
    {

    }

    #[Route('/topic_all', name: 'app_topic_all')]
    public function index(): Response
    {
        $topics = $this->topicRepository->findAll();

        return $this->render('topic/index.html.twig', [
            'topics' => $topics,
        ]);
    }

    //Ajouter un nouveau Topic
    #[Route('/topic_add/{forum_id}', name: 'app_topic_add')]
    public function add(Request $request, $forum_id): Response
    {
        /** @var Account $user */
        $user = $this->getUser();
        $topic = new Topic();
        $formTopic = $this->createForm(TopicType::class, $topic);
        $formTopic->handleRequest($request);

        $forumEntity = $this->forumRepository->find($forum_id);


        if ($formTopic->isSubmitted() && $formTopic->isValid()) {
            $topic->setCreatedAt(new \DateTime());
            $topic->setForum($forumEntity);
            $topic->setCreatedBy($user);
            $topic = $formTopic->getData();

            $this->em->persist($topic);
            $this->em->flush();

            return $this->redirectToRoute('app_forum_details', ['id' => $forum_id]);
        }

        return $this->render('topic/new.html.twig', [
            'forumTopic' => $formTopic->createView()
        ]);

    }

    #[Route('/topic_delete/{id}', name: 'app_topic_delete')]
    public function delete($id): Response
    {
        $topicEntity = $this->topicRepository->findOneBy(['id'=>$id]);

        //Avant de supprimer le topic on stock son id dans une variable pour que lorsque l'on fait la redirectio
        //on puisse faire un renvoie sur le forum sur lequel on était auparavant

        $idForum = $topicEntity->getForum()->getId();



        $this->em->remove($topicEntity);
        $this->em->flush();

        return $this->redirectToRoute('app_forum_details',['id' => $idForum]);
    }

    //Détails d'un topic
    #[Route('/topic_details/{id}', name: 'app_topic_details')]
    public function details($id)
    {
        $topicDetails = $this->topicRepository->findOneBy(['id' => $id]);

        return $this->render('message/index.html.twig', [
            'topicDetails' => $topicDetails
        ]);

    }


}
