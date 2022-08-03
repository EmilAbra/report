<?php

/**
 * Module for Card class - playing cards.
 *
 * @author Emil Abrahamsson <emilabrahamsson@yahoo.com>
 */

namespace App\Proj;

class Card
{
    /**
     * @var string $suit - The suit of the card
     * @var string $rank - The rank of the card
     * @var int $value - value of the card in Casino holdem.
     */
    private string $suit;
    private string $rank;
    private int $value;

    /**
     * Constructor for the Card class.
     *
     * @param string $suit - The suit of the card.
     * @param string $rank - The rank of the card
     * @param int $value - The value of the card
     */
    public function __construct(string $suit, string $rank, int $value)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->value = $value;
    }

    /**
     *
     * @return string - The rank of the card.
     */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     *
     * @return string - The suit of the card.
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     *
     * @return int - The value of the card.
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
