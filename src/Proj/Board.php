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
    // /**
    //  * @var object $cardHand - The Players card hand.
    //  * @var array<object> $players - The players in the game.
    //  */
    // public object $cardHand;
    // public array $players;
    //
    // /**
    //  * Constructor for the Board class.
    //  *
    //  * @param object $cardHand - The Players card hand.
    //  * @param array<object> $players - The players in the game.
    //  */
    // public function __construct(array $players)
    // {
    //     $this->cardHand = new Hand();
    //     $this->players = $players;
    // }

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
