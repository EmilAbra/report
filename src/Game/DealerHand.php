<?php

/**
 * Module for class DealerHand.
 */

namespace App\Game;

use App\Game\Card;
use App\Game\Deck;
use App\Game\Dealer;

class DealerHand
{
    /**
     * @var object $deck - The deck.
     */
    private object $deck;

    /**
     * @param $deck - Deck object.
     *
     * Constructor for the Game21Deal class.
     */
    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
    }

    /**
     * @param Dealer $dealer - Dealer object.
     * @return object<Card> - returns card object.
     *
     * Method to deal player a Card object from the Deck object and return it.
     */
    public function dealPlayer(Dealer $dealer): object
    {
        return $dealer->deal($this->deck);
    }
}
