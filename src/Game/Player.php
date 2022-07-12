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
     * @var int $money - Players money saldo, defaults to 100.
     */
    private array $cardHand = [];
    private int $cardScore = 0;
    private int $money = 100;

    /**
     *
     * Constructor for the Player class.
     */
    public function __construct()
    {
        $this->cardHand = [];
        $this->cardScore = 0;
        $this->money = 100;
    }

    /**
     * @param Card $card - Card object.
     *
     * Add Card object to card hand.
     */
    public function addToCardHand(Card $card): void
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
     * @param int $amount - money to add.
     * @return void
     *
     * Set the $money for Player.
     */
    public function setMoney(int $amount): void
    {
        $this->money += $amount;
    }

    /**
     * @return int $money - The saldo.
     *
     * Get the $money saldo.
     */
    public function getMoney(): int
    {
        return $this->money;
    }
}
