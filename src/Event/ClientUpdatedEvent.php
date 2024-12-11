<?php

namespace App\Event;

use App\Entity\Client;

class ClientUpdatedEvent
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
