<?php

/**
 * Module for Board class - for playing cards.
 *
 * @author Emil Abrahamsson <emilabrahamsson@yahoo.com>
 */

namespace App\Proj;

use App\Proj\Deck;
use App\Proj\Card;
use App\Proj\Hand;

class Board extends Player
{
    /**
     * Add board cards to players hands.
     *
     * @param array<object> $players - The players in the game.
     * @return void
     */
    public function shareCardsWithPlayers(array $players): void
    {
        foreach ($players as $player) {
            foreach ($this->cardHand->getDeck() as $card) {
                $player->setCardHand($card);
            }
        }
    }
}
