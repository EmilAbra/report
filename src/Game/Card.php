<?php

/**
 * Module for Card class - playing cards.
 */

namespace App\Game;

class Card
{
    /**
     * @var string $suit - The suit of the card
     * @var string $rank - The rank of the card
     * @var bool $convertedAce - If the card is converted from 14 points to 1.
     * Defaults to False.
     */
    private string $suit;
    private string $rank;
    private bool $convertedAce;

    /**
     * @param string $suit - The suit of the card.
     * @param string $rank - The rank of the card
     *
     * Constructor for the Card class.
     */
    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
        $this->convertedAce = false;
    }

    /**
     * @return void
     *
     * Set the variable $convertedAce to True if its an Ace and is converted
     * from 14 points to 1.
     */
    public function setConvertedAce(): void
    {
        $this->convertedAce = true;
    }

    /**
     *
     * @return bool - True or False if variable $convertedAce its an Ace and
     * is converted from 14 points to 1.
     */
    public function isConvertedAce(): bool
    {
        return $this->convertedAce;
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
}
