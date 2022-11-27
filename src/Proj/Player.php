<?php

/**
 * Module for class Player in card game.
 */

namespace App\Proj;

use App\Proj\Card;
use App\Proj\Hand;

class Player
{
    /**
     * @var object $cardHand - The card hand.
     */
    public object $cardHand;

    /**
     * Constructor for the Player class.
     *
     */
    public function __construct()
    {
        $this->cardHand = new Hand();
    }

    /**
     * Add Card object to card hand.
     *
     * @param Card $card - Card object.
     */
    public function setCardHand(Card $card): void
    {
        $this->cardHand->setDeck($card);
    }

    /**
     * @return array $cardHand - Array with Card objects.
     */
    public function getCardHand(): array
    {
        return $this->cardHand->getDeck();
    }

    /**
     * Reset the $cardHand to empty.
     *
     * @return void
     */
    public function resetCardhand(): void
    {
        $this->cardHand->resetDeck();
    }
}
