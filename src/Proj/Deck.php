<?php

/**
 * Module for Deck class - for playing cards.
 */

namespace App\Proj;

use App\Proj\Card;

class Deck
{
    /**
     * @var array<string> RANKS - Ranks in the Deck.
     */
    private const RANKS = [
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        'J',
        'Q',
        'K',
        'A'
    ];

    /**
     * @var array<string> SUITS - Suits in the Deck.
     */
    private const SUITS = [
        'diams',
        'hearts',
        'spades',
        'clubs'
    ];

    /**
     * @var array<object> $deck - defaults to empty.
     */
    private array $deck;

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
     * @param Card $card - Card object.
     * @return void
     *
     * Add Card object to $deck.
     */
    public function setDeck(Card $card): void
    {
        $this->deck[] = $card;
    }

    /**
     * @return void
     *
     * Setup deck with new Card object for RANKS and SUITS. 52 Cards.
     * Calls method setDeck with every inner iteration.
     */
    public function setupDeck(): void
    {
        foreach ($this->getSuits() as $suit) {
            foreach ($this->getRanks() as $rank) {
                $card = new Card($suit, $rank);
                $this->setDeck($card);
            }
        }
    }

    /**
     * @return void
     *
     * Reset the $deck to empty array.
     */
    public function resetDeck(): void
    {
        $this->deck = [];
    }

    /**
     * @return array<object> $deck
     *
     * Get the $deck array.
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * @return void
     *
     * Shuffle the Cards in the $deck array.
     */
    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    /**
     * @return Card - From the $deck array.
     *
     * Get and return the last Card object in $deck array.
     */
    public function drawCard(): object
    {
        return array_pop($this->deck);
    }

    /**
     * @return array<string> RANKS.
     *
     * Return RANKS array.
     */
    public function getRanks(): array
    {
        return self::RANKS;
    }

    /**
     * @return array<string> SUITS
     *
     * Return SUITS array.
     */
    public function getSuits(): array
    {
        return self::SUITS;
    }

    /**
     * @return int - number of cards.
     *
     * Return number of cards in $deck array.
     */
    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }
}
