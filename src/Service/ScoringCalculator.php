<?php

namespace App\Service;

use App\Dto\Internal\ScoringDto;
use App\Entity\Client;
use App\Service\Rules\AgreementRule;
use App\Service\Rules\DomenRule;
use App\Service\Rules\EducationRule;
use App\Service\Rules\MobileOperatorRule;
use App\Service\Rules\ScoringRuleInterface;

class ScoringCalculator
{
    /** @var ScoringRuleInterface[] */
    private array $rules = [];

    public function __construct(
        private readonly MobileOperatorRule $mobileOperatorRule,
        private readonly DomenRule $domenRule,
        private readonly EducationRule $educationRule,
        private readonly AgreementRule $agreementRule,
    ) {
        $this->rules[] = $this->mobileOperatorRule;
        $this->rules[] = $this->domenRule;
        $this->rules[] = $this->educationRule;
        $this->rules[] = $this->agreementRule;
    }

    public function calculate(Client $client): ScoringDto
    {
        $totalScore = 0;
        $results = [];
        foreach ($this->rules as $rule) {
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
