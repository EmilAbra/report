<?php

/**
 * Module for class Game21 - cardgame.
 */

namespace App\Game;

use App\Game\Card;
use App\Game\Deck;
use App\Game\Dealer;
use App\Game\Player;
use App\Game\Game21CardValues;
use App\Game\DealerHand;

class Game21
{
    /**
     * @var object $dealer - The dealer.
     * @var object $player - The player.
     * @var object $cardValues - The card values.
     */
    private object $dealer;
    private object $player;
    private object $cardValues;
    private object $dealerHand;

    /**
     * @param $dealer - Dealer object.
     * @param $player - Player object.
     * @param $cardValues - Game21CardValues object.
     * @param $dealerHand - DealerHand object.
     *
     * Constructor for the Game21 class.
     */
    public function __construct(
        Dealer $dealer,
        Player $player,
        Game21CardValues $cardValues,
        DealerHand $dealerHand
    ) {
        $this->dealer = $dealer;
        $this->player = $player;
        $this->cardValues = $cardValues;
        $this->dealerHand = $dealerHand;
    }

    /**
     * @param int $score - The players score from the card values.
     * @param int $betAmount - Money the player has placed in the bet.
     * @return mixed - returns string with message if score is 21 or over 21,
     * else null.
     *
     * Method to handle players score with a return message if score is 21 or
     * over 21, and updates the money saldos by calling method setSaldo.
     * If score is over 21: calls method fixIfAcesInHand to lower score of Ace to 1.
     * Else returns null so the player can choose again.
     */
    public function handlePlayerScore(int $score, int $betAmount): mixed
    {
        if ($score === 21) {
            $this->player->setSaldo($betAmount);
            $this->dealer->setSaldo(-$betAmount);
            return "Du fick 21!!! Grattis du vann denna omgången!";
        } elseif ($score > 21) {
            if ($this->cardValues->fixIfAcesInHand($this->player) > 21) {
                $this->player->setSaldo(-$betAmount);
                $this->dealer->setSaldo($betAmount);
                return "Ajdå, Du fick över 21!";
            }
        }
        return null;
    }

    /**
     * @param int $betAmount - Money the player has placed in the bet.
     * @return mixed - returns string with message if score is 21 or over 21,
     * else null, by calling method handlePlayerScore.
     *
     * Method to deal player a card and update players cardpoints. Call methods
     * handlePlayerScore to check if score is over 21 or equal to 21.
     */
    public function playerTurn(int $betAmount): mixed
    {
        $card = $this->dealerHand->dealPlayer($this->dealer);
        $this->player->setCardHand($card);
        $points = $this->cardValues->getValue($card);
        $this->player->setScore($points);
        $score = $this->player->getScore();

        return $this->handlePlayerScore($score, $betAmount);
    }

    /**
     * @param int $score - The banks score from the card values.
     * @param int $betAmount - Money the player has placed in the bet.
     * @return string - returns string with message if score is 21, over 21, or
     * the player has better score than the bank. Else null.
     *
     * Method to handle banks score with a return message, and updates the
     * money saldos by calling method setSaldo.
     */
    public function handleBankScore(int $score, int $betAmount): string
    {
        if ($score === 21) {
            $this->player->setSaldo(-$betAmount);
            $this->dealer->setSaldo($betAmount);
            return "Aj, Banken fick 21!";
        } elseif ($score >= $this->player->getScore()) {
            $this->player->setSaldo(-$betAmount);
            $this->dealer->setSaldo($betAmount);
            return "Ajdå, Banken hade bättre kort!";
        }
        return "Bra, Du hade bättre kort än Banken!!!";
    }

    /**
     * @param int $betAmount - Money the player has placed in the bet.
     * @return mixed - returns string with message if score is 21 or over 21,
     * else null, by calling method handlePlayerScore.
     *
     * While loop to deal the bank dealer cards until the points is over 16.
     * If score is over 21: calls method fixIfAcesInHand to lower score of Ace to 1.
     * If score still over 21: Calls method setSaldo and returns a message.
     * After loop calls handleBankScore to get and return a proper message based on the score.
     */
    public function bankTurn(int $betAmount): mixed
    {
        while ($this->dealer->getScore() < 17) {
            $card = $this->dealerHand->dealPlayer($this->dealer);
            $this->dealer->setCardHand($card);
            $points = $this->cardValues->getValue($card);
            $this->dealer->setScore($points);
            if ($this->dealer->getScore() > 21) {
                if ($this->cardValues->fixIfAcesInHand($this->dealer) > 21) {
                    $this->player->setSaldo($betAmount);
                    $this->dealer->setSaldo(-$betAmount);
                    return "Grattis, Banken fick över 21!!!";
                }
            }
        }
        $score = $this->dealer->getScore();
        return $this->handleBankScore($score, $betAmount);
    }
}
