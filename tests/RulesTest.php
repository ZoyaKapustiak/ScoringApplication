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
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RulesTest extends KernelTestCase
{
    private MobileOperatorRule $mobileOperatorRule;
    private DomenRule $domenRule;
    private EducationRule $educationRule;
    private AgreementRule $agreementRule;

    public function setUp(): void
    {
        parent::setUp();
        $container = static::getContainer();
        $this->mobileOperatorRule = $container->get(MobileOperatorRule::class);
        $this->domenRule = $container->get(DomenRule::class);
        $this->educationRule = $container->get(EducationRule::class);
        $this->agreementRule = $container->get(AgreementRule::class);
    }

    public function testSuccessOperatorRuleScore(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Higher)
            ->setIsAgreement(true)
        ;
        $expectedMobile = MobileOperatorRule::MOBILE_SCORES[MobileOperatorEnum::Mts->value];

        $result = $this->mobileOperatorRule->calculate($client)->getScore();
        $this->assertSame($expectedMobile, $result);
    }

    public function testSuccessDomenRuleScore(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Higher)
            ->setIsAgreement(true)
        ;
        $expected = DomenRule::EMAIL_SCORES[EmailDomenEnum::Gmail->value];

        $result = $this->domenRule->calculate($client)->getScore();
        $this->assertSame($expected, $result);
    }

    public function testSuccessEducationRuleScore(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Middle)
            ->setIsAgreement(true)
        ;
        $expected = EducationRule::EDUCATION_SCORES[EducationEnum::Middle->value];

        $result = $this->educationRule->calculate($client)->getScore();
        $this->assertSame($expected, $result);
    }

    public function testSuccessAgreementRuleScore(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Middle)
            ->setIsAgreement(false)
        ;
        $expected = AgreementRule::AGREEMENT_SCORES[false];

        $result = $this->agreementRule->calculate($client)->getScore();
        $this->assertSame($expected, $result);
    }

    public function testSuccessOperatorRuleName(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Higher)
            ->setIsAgreement(true)
        ;
        $expectedMobile = MobileOperatorRule::NAME.MobileOperatorEnum::Mts->value;

        $result = $this->mobileOperatorRule->calculate($client)->getName();
        $this->assertSame($expectedMobile, $result);
    }

    public function testSuccessDomenRuleName(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Higher)
            ->setIsAgreement(true)
        ;
        $expected = DomenRule::NAME.EmailDomenEnum::Gmail->value;

        $result = $this->domenRule->calculate($client)->getName();
        $this->assertSame($expected, $result);
    }

    public function testSuccessEducationRuleName(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Middle)
            ->setIsAgreement(true)
        ;
        $expected = EducationRule::NAME.EducationEnum::Middle->value;

        $result = $this->educationRule->calculate($client)->getName();
        $this->assertSame($expected, $result);
    }

    public function testSuccessAgreementRuleName(): void
    {
        $client = new Client()
            ->setFirstName('Test')
            ->setLastName('Test')
            ->setPhone('89111111111')
            ->setEmail('test@gmail.com')
            ->setEducationType(EducationEnum::Middle)
            ->setIsAgreement(false)
        ;
        $expected = AgreementRule::NAME.'HasNot';

        $result = $this->agreementRule->calculate($client)->getName();
        $this->assertSame($expected, $result);
    }
}
