<?php

namespace App\Command;

use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:change-all-password',
    description: 'Add a short description for your command',
)]
class ChangeAllPasswordCommand extends Command
{
    private AccountRepository $accountRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param AccountRepository $accountRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(AccountRepository $accountRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->accountRepository = $accountRepository;
        $this->entityManager = $entityManager;
    }


    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $accountEntities = $this->accountRepository->findAll();

        foreach ($accountEntities as $accountEntity)
        {
            $accountEntity->setPassword('$2y$13$EFfTHYwhHCu.wrq6M/MDv.4lIhzEcTe4zlnZy65eTcB56iUFA9lla');
            $this->entityManager->persist($accountEntity);
        }
        $this->entityManager->flush();
        $output->writeln("Il y a ".count($accountEntities)."mot de passe qui ont été changé !");

        return Command::SUCCESS;
    }
}
