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
}
