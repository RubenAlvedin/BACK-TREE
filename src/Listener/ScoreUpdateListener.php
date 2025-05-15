<?php

namespace App\Listener;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\User;
use RuntimeException;

#[AsEntityListener(event: 'preUpdate', method: 'preUpdate', entity: Score::class)]
class ScoreUpdateListener
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private Security $security,
    ) {
    }

    public function preUpdate(Score $score, PreUpdateEventArgs $event): void
    {
        // Vérifie si le champ "score" a changé
        if ($event->hasChangedField('score')) {
            $newScore = $event->getNewValue('score');
            
            $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new RuntimeException('Invalid user.');
        }
            // Exemple d'appel à un microservice externe
            $this->httpClient->request('POST', 'http://host.docker.internal:8001/send-mail', [
                'headers' => [
                    'Authorization' => 'abcd1234-super-cle-secrete',
                ],
                'json' => [
                    'to' => $user->email,
                    'subject' => 'Ton score a changé !',
                    'message' => "Bonjour {$user->firstName}, ton nouveau score est : {$newScore}.",
                ]
            ]);
        }
    }
}