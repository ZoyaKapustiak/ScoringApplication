<?php

namespace App\Service\Rules;

use App\Entity\Client;
use App\Enum\EmailDomenEnum;

class DomenRule implements ScoringRuleInterface
{
    private EmailDomenEnum $emailDomen;
    private int $score;
    public const array EMAIL_SCORES = [
        EmailDomenEnum::Gmail->value => 10,
        EmailDomenEnum::Yandex->value => 8,
        EmailDomenEnum::Mail->value => 6,
        EmailDomenEnum::Other->value => 3,
    ];
    public const string NAME = 'Domen ';

    public function calculate(Client $client): static
    {
        $this->emailDomen = $this->defineDomen($client->getEmail());
        $this->setScore($this->emailDomen);

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getName(): string
    {
        return self::NAME.$this->emailDomen->value;
    }

    private function defineDomen(string $email): EmailDomenEnum
    {
        $domen = explode('.', explode('@', $email)[1])[0];

        return EmailDomenEnum::tryFrom(mb_ucfirst($domen)) ?? EmailDomenEnum::Other;
    }

    private function setScore(EmailDomenEnum $domen): void
    {
        $this->score = match ($domen) {
            EmailDomenEnum::Gmail,
            EmailDomenEnum::Yandex,
            EmailDomenEnum::Mail,
            EmailDomenEnum::Other => self::EMAIL_SCORES[$domen->value],
        };
    }
}
