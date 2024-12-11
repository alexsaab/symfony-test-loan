<?php

namespace App\EventListener;

use App\Enum\CreditStatus;
use App\Event\CreditCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreditCreatedListener implements EventSubscriberInterface
{

    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function onCreditCreated(CreditCreatedEvent $event)
    {
        // Perform some action after creating a credit

        $client = $event->getClient();
        $credit = $event->getCredit();

        // Расчитываем тут Кредитный рейтинг клиента (случайно)
        $client->setFico(rand(300,850));
        $this->entityManager->persist($client);
        $this->entityManager->flush();

        if ($client->getFico() < 500) {
            $credit->setStatus(CreditStatus::DECLINED);
        } elseif ($client->getAge() > 60 || $client->getAge() < 18) {
            $credit->setStatus(CreditStatus::DECLINED);
        } elseif  ($client->getAverageMonthlyIncome() < 1000) {
            $credit->setStatus(CreditStatus::DECLINED);
        } elseif  (!in_array($client->getState(), ['CA', 'NY', 'NV'])) {
            $credit->setStatus(CreditStatus::DECLINED);
        } elseif  ($client->getState() === 'NY' && rand(0,20) < 5) {
            $credit->setStatus(CreditStatus::DECLINED);
        } else {
            $credit->setStatus(CreditStatus::ACCEPTED);
        }

        if ($client->getState() === 'CA') {
            $currentRate = number_format($credit->getPercent(), 2, '.', '');
            $credit->setPercent($currentRate + 11.49);
        }

        $this->entityManager->persist($credit);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreditCreatedEvent::class => 'onCreditCreated',
        ];
    }
}
