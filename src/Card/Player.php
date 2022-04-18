<?php

namespace App\Card;
use App\Card\CardHand;


class Player
{
    private object $playerCards;

    public function __construct($cardHand)
    {
        $this->playerCards = $cardHand;
    }

    public function getPlayerCards(): object
    {
        return $this->playerCards;
    }
}
