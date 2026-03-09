<?php

namespace App\Service;

use App\Dto\Internal\ScoringDto;
use App\Entity\Client;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class ScoringCalculator
{
    public function __construct(
        #[AutowireIterator('scoring.rules')]
        private readonly iterable $scoringRules,
    ) {
    }

    public function calculate(Client $client): ScoringDto
    {
        $totalScore = 0;
        $results = [];
        foreach ($this->scoringRules as $rule) {
            $scoring = $rule->calculate($client);
            $results[$scoring->getName()] = $scoring->getScore();
            $totalScore += $scoring->getScore();
        }

        return new ScoringDto(
            scores: $results,
            totalScore: $totalScore
        );
    }
}
