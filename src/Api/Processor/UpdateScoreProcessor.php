<?php declare(strict_types=1);

namespace App\Api\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Score;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\VarDumper\Cloner\Data;

final readonly class UpdateScoreProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
    ) {
    }

    /** @param Score $data */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): Score {


        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new RuntimeException('Invalid user.');
        }
        
        if (!$data->user) {
            $data->user = $user;
        }


        $this->em->persist($data);
        $this->em->flush();

        return $data;

    }
}
