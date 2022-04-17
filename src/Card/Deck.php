<?php

namespace App\Card;

use App\Card\Card;

class Deck
{
    const RANKS = [
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
    const SUITS = [
        'diams',
        'hearts',
        'spades',
        'clubs'
    ];
    private array $deck;

    public function __construct(array $deck = [])
    {
        $this->deck = $deck;
    }

    public function setDeck(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function drawCard(): object
    {
        return array_pop($this->deck);
    }

    public function drawMany(int $number): array
    {
        $cards = array_splice($this->deck, -$number);
        return $cards;
    }

    public function getRanks(): array
    {
        return self::RANKS;
    }

    public function getSuits(): array
    {
        return self::SUITS;
    }

    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }
}
