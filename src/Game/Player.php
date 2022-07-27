<?php

/**
 * Module for class Player in cardgame 21.
 */

namespace App\Game;

use App\Game\Game21;
use App\Game\Card;

class Player
{
    /**
     * @var array<object> $cardHand - The Players cardhand, defaults to empty.
     * @var int $cardScore - Players total cardscore, defaults to zero.
     * @var int $saldo - Players money saldo, defaults to 100.
     */
    private array $cardHand = [];
    private int $cardScore = 0;

    /**
     * @param array<object> $cardHand - Players start hand.
     * @param int $cardScore - start card score.
     *
     * Constructor for the Player class.
     */
    public function __construct(array $cardHand = [], int $cardScore = 0)
    {
        $this->cardHand = $cardHand;
        $this->cardScore = $cardScore;
    }

    /**
     * @param Card $card - Card object.
     *
     * Add Card object to card hand.
     */
    public function setCardHand(Card $card): void
    {
        $this->cardHand[] = $card;
    }

    /**
     * @return array<object> $cardHand - Array with Card objects.
     */
    public function getCardHand(): array
    {
        return $this->cardHand;
    }

    /**
     * @return void
     *
     * Reset the $cardHand to empty.
     */
    public function resetCardhand(): void
    {
        $this->cardHand = [];
    }

    /**
     * @param int $points - points to add to score.
     * @return void
     *
     * Set the score for Player.
     */
    public function setScore(int $points): void
    {
        $this->cardScore += $points;
    }

    /**
     * @return int $cardScore - points.
     *
     * Get the score for Player.
     */
    public function getScore(): int
    {
        return $this->cardScore;
    }

    /**
     * @return void
     *
     * Reset the $cardScore to zero.
     */
    public function resetScore(): void
    {
        $this->cardScore = 0;
    }

    /**
     * @return bool - if saldo is under 1
     *
     * Check if saldo is empty.
     */
    public function isSaldoEmpty(): bool
    {
        return $this->getSaldo() < 1;
    }

    /**
     * @param $amount - amount to be changed for the saldo.
     * @return void
     *
     * Update saldo.
     */
    public function setSaldo(int $amount): void
    {
        $this->saldo += $amount;
    }

    /**
     * @return integer - The saldo
     *
     * Get saldo.
     */
    public function getSaldo(): int
    {
        return $this->saldo;
    }
}
