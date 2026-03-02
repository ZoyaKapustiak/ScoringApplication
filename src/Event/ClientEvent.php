<?php

namespace App\Event;

use App\Entity\Client;
use App\Service\ScoringCalculator;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, entity: Client::class)]
readonly class ClientEvent
{
    public function __construct(
        private ScoringCalculator $scoringCalculator,
    ) {
    }

    public function __invoke(Client $client): void
    {
        $dto = $this->scoringCalculator->calculate($client);
        $client->setScoring($dto->totalScore);
    }
}
