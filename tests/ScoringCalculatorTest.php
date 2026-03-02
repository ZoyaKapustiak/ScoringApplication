<?php

namespace App\Tests;

use App\Entity\Client;
use App\Enum\EducationEnum;
use App\Enum\EmailDomenEnum;
use App\Enum\MobileOperatorEnum;
use App\Service\Rules\AgreementRule;
use App\Service\Rules\DomenRule;
use App\Service\Rules\EducationRule;
use App\Service\Rules\MobileOperatorRule;
use App\Service\ScoringCalculator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ScoringCalculatorTest extends KernelTestCase
{
    private ScoringCalculator $scoringCalculator;

    public function setUp(): void
    {
        parent::setUp();
        $container = static::getContainer();
        $this->scoringCalculator = $container->get(ScoringCalculator::class);
    }

    public function testSuccessScoringCalculate(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89211111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Higher)
            ->setIsAgreement(true)
        ;
        $expectedValue = MobileOperatorRule::MOBILE_SCORES[MobileOperatorEnum::Megafon->value]
            + DomenRule::EMAIL_SCORES[EmailDomenEnum::Gmail->value]
            + EducationRule::EDUCATION_SCORES[EducationEnum::Higher->value]
            + AgreementRule::AGREEMENT_SCORES[true];

        $dto = $this->scoringCalculator->calculate($client);

        $this->assertSame($dto->totalScore, $expectedValue);
    }
}
