<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var array<object> $cardHand
     */
    private array $cardHand;

    /**
     * @param array<object> $cards
     */
    public function __construct(array $cards)
    {
        $this->cardHand = $cards;
    }

    /**
     * @return array<object> $cardHand
     */
    public function getCardHand(): array
    {
        return $this->cardHand;
    }
}
