<?php

namespace App\Service\Rules;

use App\Entity\Client;

class AgreementRule implements ScoringRuleInterface
{
    private bool $isAgree;
    private int $score;
    public const array AGREEMENT_SCORES = [
        true => 4,
        false => 0,
    ];

    public const string NAME = 'Agreement ';

    public function calculate(Client $client): static
    {
        $this->isAgree = $client->isAgreement();
        $this->score = self::AGREEMENT_SCORES[$this->isAgree];

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getName(): string
    {
        $agree = $this->isAgree ? 'Has' : 'HasNot';

        return self::NAME.$agree;
    }
}
