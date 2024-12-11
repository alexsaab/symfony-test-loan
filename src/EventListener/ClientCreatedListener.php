<?php

namespace App\EventListener;

use App\Event\ClientCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ClientCreatedListener implements EventSubscriberInterface
{
    public function onClientCreated(ClientCreatedEvent $event)
    {
        // Perform some action after creating a client
        // dump($event->getClient());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ClientCreatedEvent::class => 'onClientCreated',
        ];
    }
}
