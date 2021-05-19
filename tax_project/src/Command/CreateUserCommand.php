<?php

namespace App\Command;

use App\Entity\User;
use App\Service\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a manager (Gestionnaire), you must set an username and a password in as arguments')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The pass of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $user->setEmail($input->getArgument('email'));
        $user->setPassword($input->getArgument('password'));
        $user->setRoles(['ROLE_MANAGER']);

        $this->userManager->addAnUserWithManagerRole($user);
        return Command::SUCCESS;
    }
}

