<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use App\Repository\AccountRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    public function __construct(private AccountRepository $accountRepository) { }

    #[Route('/utilisateurs/{slug}/commentaires', name: 'app_account_comments_show')]
    public function userBySlugAllComments($slug): Response
    {
        $userEntity = $this->accountRepository->getOneAccountBySlug($slug);

        return $this->render('account/account_comments.html.twig', [
            'userEntity' => $userEntity,
        ]);
    }

    #[Route('/utilisateurs', name: 'app_accounts')]
    public function getAllAccount():Response
    {
        $accountEntities = $this->accountRepository->findAll();

        return $this->render('account/all_account.html.twig', [

        ]);
    }

    #[Route('/utilisateurs/nouveau', name: 'app_account_new_show')]
    public function show(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AccountType::class, $account = new Account());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $account->setCreatedAt(new DateTime());
            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute('app_accounts');
        }

        return $this->render('account/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //on met la fonction ici car la route avec paramètre rentre en conflit avec la route avec /utilisateur/nouveau
    #[Route('/utilisateurs/{slug}', name: 'app_account_show')]
    public function userBySlug($slug): Response
    {
        $userEntity = $this->accountRepository->getOneAccountBySlug($slug);

        return $this->render('account/index.html.twig', [
            'userEntity' => $userEntity,
        ]);
    }

}
