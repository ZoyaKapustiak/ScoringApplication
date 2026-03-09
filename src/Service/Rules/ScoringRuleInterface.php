<?php

namespace App\Service\Rules;

use App\Entity\Client;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'scoring.rules')]
interface ScoringRuleInterface
{
    public function calculate(Client $client): static;

    public function getScore(): int;

    public function getName();
}
