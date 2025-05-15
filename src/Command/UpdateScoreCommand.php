<?php declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\User;

#[AsCommand(
    name: 'app:update:score',
    description: 'Update a user score',
)]
class UpdateScoreCommand extends Command
{
    public function __construct(

        private EntityManagerInterface $em
    ){
    }

    public function configure(): void
    {
        $this
            ->addOption('userUuid', null, InputOption::VALUE_REQUIRED, 'The UUID of the user')
            ->addOption('score', null, InputOption::VALUE_REQUIRED, 'The new score of the user');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
    try {
        
        $userUuid = $input->getOption('userUuid');
        $score = $input->getOption('score');
        $user = $this->em->getRepository(User::class)->findOneBy(['uuid' => $userUuid]);
        if (!$user) {
            $output->writeln("User with UUID {$userUuid} not found.");
            return Command::FAILURE;
        }

        $user->score = $score;
        $this->em->persist($user);
        $this->em->flush();

        return Command::SUCCESS;

    } catch (\Throwable $exception) {
            $output->writeln("Error updating score: {$exception->getMessage()}");
            return Command::FAILURE;
        }
    }
}

    
    