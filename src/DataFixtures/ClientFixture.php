<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Enum\EducationEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $clients = [
            [
                'firstName' => 'Иван',
                'lastName' => 'Иванов',
                'phone' => '+7 (999) 123-45-67',
                'email' => 'ivan@example.com',
                'educationType' => EducationEnum::Higher,
                'scoring' => 85,
            ],
            [
                'firstName' => 'Петр',
                'lastName' => 'Петров',
                'phone' => '+7 (999) 234-56-78',
                'email' => 'petr@example.com',
                'educationType' => EducationEnum::Middle,
                'scoring' => 70,
            ],
            [
                'firstName' => 'Анна',
                'lastName' => 'Сидорова',
                'phone' => '+7 (999) 345-67-89',
                'email' => 'anna@example.com',
                'educationType' => EducationEnum::Special,
                'scoring' => 90,
            ],
            [
                'firstName' => 'Елена',
                'lastName' => 'Смирнова',
                'phone' => '+7 (999) 456-78-90',
                'email' => 'elena@example.com',
                'educationType' => EducationEnum::Higher,
                'scoring' => 75,
            ],
            [
                'firstName' => 'Дмитрий',
                'lastName' => 'Козлов',
                'phone' => '+7 (999) 567-89-01',
                'email' => 'dmitry@example.com',
                'educationType' => EducationEnum::Middle,
                'scoring' => 65,
            ],
            [
                'firstName' => 'Ольга',
                'lastName' => 'Новикова',
                'phone' => '+7 (999) 678-90-12',
                'email' => 'olga@example.com',
                'educationType' => EducationEnum::Special,
                'scoring' => 80,
            ],
            [
                'firstName' => 'Александр',
                'lastName' => 'Морозов',
                'phone' => '+7 (999) 789-01-23',
                'email' => 'alex@example.com',
                'educationType' => EducationEnum::Higher,
                'scoring' => 95,
            ],
            [
                'firstName' => 'Наталья',
                'lastName' => 'Волкова',
                'phone' => '+7 (999) 890-12-34',
                'email' => 'nataly@example.com',
                'educationType' => EducationEnum::Middle,
                'scoring' => 60,
            ],
            [
                'firstName' => 'Максим',
                'lastName' => 'Лебедев',
                'phone' => '+7 (999) 901-23-45',
                'email' => 'maxim@example.com',
                'educationType' => EducationEnum::Special,
                'scoring' => 88,
            ],
            [
                'firstName' => 'Татьяна',
                'lastName' => 'Соколова',
                'phone' => '+7 (999) 012-34-56',
                'email' => 'tatiana@example.com',
                'educationType' => EducationEnum::Higher,
                'scoring' => 72,
            ],
        ];

        foreach ($clients as $index => $data) {
            $client = new Client();
            $client->setFirstName($data['firstName']);
            $client->setLastName($data['lastName']);
            $client->setPhone($data['phone']);
            $client->setEmail($data['email']);
            $client->setEducationType($data['educationType']);
            $client->setIsAgreement(true);
            $client->setScoring($data['scoring']);

            $manager->persist($client);

            // Сохраняем ссылку на фикстуру для использования в других фикстурах
            $this->addReference('client-'.$index, $client);
        }

        $manager->flush();
    }
}
