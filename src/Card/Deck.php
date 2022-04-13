<?php

namespace App\Card;

use App\Card\Card;

class Deck
{
    private $ranks = [
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
    private $suits = [
        'diams',
        'hearts',
        'spades',
        'clubs'
    ];
    private $deck = [];

    public function addCard(Card $card): void
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

    public function test() {
        $arr = [];
        foreach ($this->getDeck() as $object)
        {
            $arr[$object->getSuit()] = $object->getRank();
        }
        print_r($arr);

    }

    public function drawCard(): object
    {
        return array_pop($this->deck);
    }

    public function getRanks(): array
    {
        return $this->ranks;
    }

    public function getSuits(): array
    {
        return $this->suits;
    }

    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }
}
