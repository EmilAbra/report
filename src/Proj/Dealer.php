<?php

/**
 * Module for Dealer class - poker game dealer.
 *
 * @author Emil Abrahamsson <emilabrahamsson@yahoo.com>
 */

namespace App\Proj;

use App\Proj\Player;

class Dealer
{
    /**
     * @var object $deck - The Deck of Cards.
     */
    private object $deck;

    /**
     * Constructor for the Dealer class.
     *
     * @param $deck - Card Deck object.
     */
    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
    }

    /**
     * Method to deal cards.
     *
     * @param Player $player - Player object to deal to.
     * @return void
     */
    public function deal(Player $player, int $amount): void
    {
        $cards = $this->deck->drawCards($amount);
        foreach ($cards as $card) {
            $player->setCardHand($card);
        }
    }
}
