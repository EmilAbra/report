<?php

namespace App\Card;

class Card
{
    private $suit;
    private $rank;

    public function __construct($suit, $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }
}
