<?php

/**
 * Module for class Rules
 */

namespace App\Proj;

class Rules
{
    /**
     * @var array<string|int> CARD_VALUES - Scores for each card rank in Texas Holdem.
     */
    public const CARD_VALUES = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14
    ];

    /**
     * Constructor for the Game21CardValues class.
     */
    public function __construct()
    {
    }

    /**
     * @param Card $card - Card object.
     *
     * @return int - card value.
     *
     * Return point value for the Cards rank in CARD_VALUES variable.
     */
    public function getValue(Card $card): int
    {
        $rank = $card->getRank();
        return self::CARD_VALUES[$rank];
    }
}
