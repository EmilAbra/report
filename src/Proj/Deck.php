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
     * @param array<object> $deck
     *
     * Constructor for the Deck class.
     */
    public function __construct(array $deck = [])
    {
        $this->deck = $deck;
        $this->setupDeck();
        $this->shuffle();
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
     * Setup deck with new Card object for RANKS and SUITS. 52 Cards.
     * Calls method setDeck with every inner iteration.
     */
    private function setupDeck(): void
    {
        $suits = $this->getSuits();
        $ranks = $this->getRanks();
        $values = $this->getValues();
        for ($i=0; $i < count($suits); $i++) {
            for ($j=0; $j < count($ranks); $j++) {
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
     * @return array<int> VALUES
     *
     * Return VALUES array.
     */
    public function getValues(): array
    {
        return self::VALUES;
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
