<?php

namespace App\Service\Rules;

use App\Entity\Client;

interface ScoringRuleInterface
{
    public function calculate(Client $client): static;

    public function getScore(): int;

    public function getName();
}
