<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    public function __construct(private AccountRepository $accountRepository) { }

    #[Route('/utilisateurs/{slug}', name: 'app_account_show')]
    public function userBySlug($slug): Response
    {
        $userEntity = $this->accountRepository->getOneAccountBySlug($slug);

        return $this->render('account/index.html.twig', [
            'userEntity' => $userEntity,
        ]);
    }

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
        $accountEntities = $this->accountRepository->findBy([],['createdAt' => 'DESC']);
        dump($accountEntities);

        return $this->render('account/all_account.html.twig', [
            'accounts' => $accountEntities,
        ]);
    }
}
