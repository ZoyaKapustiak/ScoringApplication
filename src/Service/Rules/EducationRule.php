<?php

namespace App\Service\Rules;

use App\Entity\Client;
use App\Enum\EducationEnum;

class EducationRule implements ScoringRuleInterface
{
    private EducationEnum $education;
    private int $score;
    public const array EDUCATION_SCORES = [
        EducationEnum::Higher->value => 15,
        EducationEnum::Special->value => 10,
        EducationEnum::Middle->value => 5,
    ];
    public const string NAME = 'Education ';

    public function calculate(Client $client): static
    {
        $this->education = $client->getEducationType();
        $this->setScore($this->education);

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getName(): string
    {
        return self::NAME.$this->education->name;
    }

    private function setScore(EducationEnum $education): void
    {
        $this->score = match ($education) {
            EducationEnum::Higher,
            EducationEnum::Special,
            EducationEnum::Middle => self::EDUCATION_SCORES[$education->value],
        };
    }
}
