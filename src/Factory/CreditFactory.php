<?php

namespace App\Factory;

use App\Entity\Client;
use App\Entity\Credit;
use Faker\Factory;
use Doctrine\ORM\EntityManagerInterface;

class CreditFactory
{
    private EntityManagerInterface $entityManager;
    private \Faker\Generator $faker;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->faker = Factory::create();
    }

    public function createCredit(Client $client): Credit
    {
        $credit = new Credit();

        $credit->setTitle('Loan for ' . $client->getFirstName() . ' ' . $client->getLastName());
        $credit->setAmount($this->faker->numberBetween(1000, 100000));
        $credit->setCurrency('USD');
        $credit->setPercent($this->faker->numberBetween(5, 20));
        $credit->setTerm($this->faker->numberBetween(6, 60));
        $credit->setClient($client);

        $this->entityManager->persist($credit);
        $this->entityManager->flush();

        return $credit;
    }
}
