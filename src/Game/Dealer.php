<?php

namespace App\Game;

use App\Game\Deck;
use App\Game\Card;
use App\Game\Player;

class Dealer extends Player
{
    /**
     * @param Deck $deck - Deck object.
     * @return Card - A card object from the Deck.
     *
     * Method to let the dealer deal a card.
     */
    public function deal(Deck $deck): object
    {
        return $deck->drawCard();
    }
}
