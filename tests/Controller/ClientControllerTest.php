<?php

namespace App\Tests\Controller;

use App\Entity\Client;
use App\Enum\EducationEnum;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ClientControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $clientRepository;
    private string $path = '/client/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->clientRepository = $this->manager->getRepository(Client::class);

        foreach ($this->clientRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client index');
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'client[firstName]' => 'Testing',
            'client[lastName]' => 'Testing',
            'client[phone]' => '89111161111',
            'client[email]' => 'test@test.com',
            'client[educationType]' => EducationEnum::Higher->value,
            'client[isAgreement]' => '1',
        ]);

        self::assertResponseRedirects('/client');

        self::assertSame(1, $this->clientRepository->count());
    }

    public function testShow(): void
    {
        $fixture = new Client();
        $fixture->setFirstName('My Title');
        $fixture->setLastName('My Title');
        $fixture->setPhone('89119111111');
        $fixture->setEmail('mytitle@test.com');
        $fixture->setEducationType(EducationEnum::Higher);
        $fixture->setIsAgreement(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client');
    }

    public function testEdit(): void
    {
        $fixture = new Client();
        $fixture->setFirstName('Value');
        $fixture->setLastName('Value');
        $fixture->setPhone('89110163333');
        $fixture->setEmail('test@test.com');
        $fixture->setEducationType(EducationEnum::Higher);
        $fixture->setIsAgreement(true);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'client[firstName]' => 'Something New',
            'client[lastName]' => 'Something New',
            'client[phone]' => '89110163333',
            'client[email]' => 'test@test.com',
            'client[educationType]' => 'Middle',
            'client[isAgreement]' => '1',
        ]);

        self::assertResponseRedirects('/client');

        $fixture = $this->clientRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstName());
        self::assertSame('Something New', $fixture[0]->getLastName());
        self::assertSame('89110163333', $fixture[0]->getPhone());
        self::assertSame('test@test.com', $fixture[0]->getEmail());
        self::assertSame(EducationEnum::Middle, $fixture[0]->getEducationType());
        self::assertSame(true, $fixture[0]->isAgreement());
    }
}
