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
     * @var array<int> Values - card values.
     */
    private const VALUES = [
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10,
        11,
        12,
        13,
        14
    ];


    /**
     * @var array<object> $deck - defaults to empty.
     */
    public array $deck;

    /**
     * Constructor for the Deck class.
     *
     * @param array<object> $deck
     */
    public function __construct(array $deck = [])
    {
        $this->deck = $deck;
        $this->setupDeck();
        $this->shuffle();
    }

    /**
     * Add Card object to $deck.
     *
     * @param Card $card - Card object.
     * @return void
     */
    public function setDeck(Card $card): void
    {
        $this->deck[] = $card;
    }

    /**
     * Get the $deck array.
     *
     * @return array<object> $deck
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * Setup deck with new Card object for RANKS and SUITS. 52 Cards.
     * Calls method setDeck with every inner iteration.
     *
     * @return void
     */
    private function setupDeck(): void
    {
        $suits = $this->getSuits();
        $ranks = $this->getRanks();
        $values = $this->getValues();
        $suitsLength = count($suits);
        $ranksLength = count($ranks);

        for ($i = 0; $i < $suitsLength; $i++) {
            for ($j = 0; $j < $ranksLength; $j++) {
                $card = new Card($suits[$i], $ranks[$j], $values[$j]);
                $this->setDeck($card);
            }
        }
    }

    /**
     * @return void
     *
     * Reset the $deck to empty array and set it up followed by a shuffle.
     */
    public function resetDeck(): void
    {
        $this->deck = [];
        // $this->setupDeck();
        // $this->shuffle();
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
     * Remove and Return cards from top of the deck.
     *
     * @param int $amount - How many cards from deck to draw.
     * @return array<object> - From the $deck array.
     */
    public function drawCards(int $amount): array
    {
        $cards = array_splice($this->deck, 0, $amount);
        return $cards;
    }

    /**
     * Return RANKS array.
     *
     * @return array<string> RANKS.
     */
    public function getRanks(): array
    {
        return self::RANKS;
    }

    /**
     * Return SUITS array.
     *
     * @return array<string> SUITS
     */
    public function getSuits(): array
    {
        return self::SUITS;
    }

    /**
     * Return VALUES array.
     *
     * @return array<int> VALUES
     */
    public function getValues(): array
    {
        return self::VALUES;
    }

    /**
     * Return number of cards in $deck array.
     *
     * @return int - number of cards.
     */
    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }
}
