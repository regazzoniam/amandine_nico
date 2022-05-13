<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Topic;
use App\Form\MessageType;
use App\Form\TopicType;
use App\Repository\ForumRepository;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
    public function __construct(private TopicRepository $topicRepository, private ForumRepository $forumRepository, private EntityManagerInterface $em)
    { }

    #[Route('/topic_add/{forum_id}', name: 'app_topic_add')]
    public function index($forum_id, Request $request): Response
    {
        $topic = new Topic;
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $topic = $form->getData();
            $topic->setCreatedAt(new \DateTime());
            $userentity = $this->getUser();
            $topic->setCreatedBy($userentity);

            $forumEntity = $this->forumRepository->find($forum_id);
            $topic->setForum($forumEntity);

            $this->em->persist($topic);
            $this->em->flush();
            return $this->redirectToRoute('app_forum_details',['id'=> $forum_id]);
        }

        return $this->render('topic/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //voir en détails un topic
    #[Route('/forum_details/{forum_id}/topic_details/{topic_id}', name: 'app_topic_details')]
    public function details($topic_id, $forum_id, Request $request) :Response
    {
        $topic = $this->topicRepository->find(['id' => $topic_id]);
        $forum = $this->forumRepository->find(['id' => $forum_id]);
        $message = new Message;
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            // remplacer le createdAt par la date du jour
            $message->setCreatedAt(new \DateTime());
            // remplacer le createdBypar 
            $userentity = $this->getUser();
            $message->setCreatedBy($userentity);
            // remplacer le topic
            $topicEntity = $this->topicRepository->find($topic_id);
            $message->setTopic($topicEntity);
            $this->em->persist($message);
            $this->em->flush();
        }

        return $this->render('topic/details.html.twig', [
            'topic' => $topic,
            'forum' => $forum,
            'form' => $form->createView(),
        ]);
    }

    //supprimer un topic
    #[Route('/forum_details/{forum_id}/topic_delete/{topic_id}', name: 'app_topic_delete')]
    public function delete($topic_id, $forum_id) :Response
    {
        $forum = $this->topicRepository->find(['id' => $topic_id]);
        $this->em->remove($forum);
        $this->em->flush();

        return $this->redirectToRoute('app_forum_details', ['id'=>$forum_id]);
    }
}
