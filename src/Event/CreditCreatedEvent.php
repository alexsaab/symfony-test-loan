<?php

namespace App\Event;

use App\Entity\Credit;
use App\Entity\Client;

class CreditCreatedEvent
{
    private $credit;
    private $client;

    public function __construct(Credit $credit, Client $client)
    {
        $this->credit = $credit;
        $this->client = $client;
    }

    public function getCredit(): Credit
    {
        return $this->credit;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
