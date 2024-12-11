<?php

namespace App\Factory;

use App\Entity\Client;
use Faker\Factory;
use Doctrine\ORM\EntityManagerInterface;

class ClientFactory
{
    private $entityManager;
    private $faker;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->faker = Factory::create();
    }

    public function createClient(): Client
    {
        $client = new Client();

        $client->setFirstName($this->faker->firstName);
        $client->setLastName($this->faker->lastName);
        $client->setEmail($this->faker->email);
        $client->setPhone($this->faker->phoneNumber);
        $client->setSsn($this->faker->ssn);
        $client->setState($this->faker->stateAbbr);
        $client->setPostalCode($this->faker->postcode);
        $client->setCity($this->faker->city);
        $client->setAddress($this->faker->streetAddress);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }
}
