<?php

namespace App\Card;

use App\Card\Deck;
use App\Card\Card;

class DeckWith2Jokers extends Deck
{
    public const JRANKS = [
        "big joker" => "+",
        "little joker" => "-"
    ];

    public const JSUIT = "Joker";

    public function __construct()
    {
        parent::__construct();
    }
}
