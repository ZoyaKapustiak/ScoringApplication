<?php

namespace App\Action;

use App\Dto\Internal\ScoringDto;
use App\Entity\Client;
use App\Service\ScoringCalculator;
use Doctrine\ORM\EntityManagerInterface;

class ScoringCalculateAction
{
    public function __construct(
        private readonly ScoringCalculator $scoringCalculator,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param Client[] $clients
     *
     * @return ScoringDto[]
     */
    public function updateClientsScoring(array $clients): array
    {
        $results = [];

        array_map(function (Client $client) use (&$results) {
            $dto = $this->scoringCalculator->calculate($client);
            $client->setScoring($dto->totalScore);

            $results[$client->getId()] = $dto;
        }, $clients);

        $this->entityManager->flush();

        return $results;
    }
}
