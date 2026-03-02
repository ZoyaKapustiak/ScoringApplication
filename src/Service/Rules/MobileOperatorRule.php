<?php

namespace App\Service\Rules;

use App\Entity\Client;
use App\Enum\MobileOperatorEnum;

class MobileOperatorRule implements ScoringRuleInterface
{
    private MobileOperatorEnum $mobileOperator;
    private int $score;

    public const array MOBILE_SCORES = [
        MobileOperatorEnum::Megafon->value => 10,
        MobileOperatorEnum::Beeline->value => 5,
        MobileOperatorEnum::Mts->value => 3,
        MobileOperatorEnum::Other->value => 1,
    ];
    public const string NAME = 'Operator ';

    public function calculate(Client $client): static
    {
        $operator = $this->defineOperator($client->getPhone());
        $this->mobileOperator = $operator;
        $this->setScore($operator);

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getName(): string
    {
        return self::NAME.$this->mobileOperator->name;
    }

    private function defineOperator(string $phone): MobileOperatorEnum
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $code = substr($phone, 1, 3);

        return MobileOperatorEnum::defineOperator((int) $code);
    }

    private function setScore(MobileOperatorEnum $mobile): void
    {
        $this->score = match ($mobile) {
            MobileOperatorEnum::Megafon,
            MobileOperatorEnum::Beeline,
            MobileOperatorEnum::Mts,
            MobileOperatorEnum::Other => self::MOBILE_SCORES[$mobile->value],
        };
    }
}
