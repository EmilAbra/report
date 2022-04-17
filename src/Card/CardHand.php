<?php

namespace App\Card;
use App\Card\Card;

class CardHand
{
    private array $cardHand;

    public function __construct($cards)
    {
        $this->cardHand = $cards;
    }

    // public function addCards($cards): void
    // {
    //     $this->cardHand = $cards;
    // }

    public function getCardHand(): array
    {
        return $this->cardHand;
    }
}
