<?php

/**
 * Module for Hand class - for playing cards.
 *
 * @author Emil Abrahamsson <emilabrahamsson@yahoo.com>
 */

namespace App\Proj;
use App\Proj\Deck;
use App\Proj\Card;

class Hand extends Deck
{
    /**
     * @var array<object> $deck - defaults to empty.
     */
    public array $deck;

    /**
     * @param array<object> $deck
     *
     * Constructor for the Deck class.
     */
    public function __construct(array $deck = [])
    {
        $this->deck = $deck;
    }

    /**
     * Get all card ranks in hand.
     *
     * @return array<string> RANKS.
     */
    public function getAllRanks(): array
    {
        $ranksArray = [];
        foreach ($this->deck as $card) {
            $ranksArray[] = $card->getRank();
        }
        return $ranksArray;
    }

    /**
     * Get all card suits in hand.
     *
     * @return array<string> SUITS
     */
    public function getAllSuits(): array
    {
        $suitsArray = [];
        foreach ($this->deck as $card) {
            $suitsArray[] = $card->getSuit();
        }
        return $suitsArray;
    }

    /**
     * Get all card values in hand.
     *
     * @return array<int> VALUES
     */
    public function getAllValues(): array
    {
        $valuesArray = [];
        foreach ($this->deck as $card) {
            $valuesArray[] = $card->getValue();
        }
        return $valuesArray;
    }
}
