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

class Game21
{
    /**
     * @var object $dealer - The dealer.
     * @var object $player - The player.
     */
    private object $dealer;
    private object $player;
    private object $cardValues;

    /**
     * @param $dealer - Dealer object.
     * @param $player - Player object.
     *
     * Constructor for the Game21 class.
     */
    public function __construct(Dealer $dealer, Player $player, Game21CardValues $cardValues)
    {
        $this->dealer = $dealer;
        $this->player = $player;
        $this->cardValues = $cardValues;
    }

    /**
     * @return Dealer - Dealer object.
     *
     * Get the dealer.
     */
    public function getDealer(): object
    {
        return $this->dealer;
    }

    /**
     * @return Player - Player object.
     *
     * Get the player.
     */
    public function getPlayer(): object
    {
        return $this->player;
    }

    /**
     * @param int $score - The players score from the card values.
     * @param int $betAmount - Money the player has placed in the bet.
     * @return mixed - returns string with message if score is 21 or over 21,
     * else null.
     *
     * Method to handle players score with a return message if score is 21 or
     * over 21, and updates the * money saldos by calling method updateSaldo.
     * If score is over 21: calls method fixIfAcesInHand to lower score of Ace to 1.
     * Else returns null so the player can choose again.
     */
    public function handlePlayerScore(int $score, int $betAmount): mixed
    {
        if ($score === 21) {
            $this->updateSaldo($betAmount, -$betAmount);
            return "Du fick 21!!! Grattis du vann denna omgången!";
        } elseif ($score > 21) {
            if ($this->cardValues->fixIfAcesInHand($this->player) > 21) {
                $this->updateSaldo(-$betAmount, $betAmount);
                return "Ajdå, Du fick över 21!";
            }
        }
        return null;
    }

    /**
     * @param Deck $deck - Deck object.
     * @param int $betAmount - Money the player has placed in the bet.
     * @return mixed - returns string with message if score is 21 or over 21,
     * else null, by calling method handlePlayerScore.
     *
     * Method to deal player a card and update players cardpoints. Call methods
     * handlePlayerScore to check if score is over 21 or equal to 21.
     */
    public function dealPlayer(Deck $deck, int $betAmount): mixed
    {
        $card = $this->dealer->deal($deck);
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
     * money saldos by calling method updateSaldo.
     */
    public function handleBankScore(int $score, int $betAmount): string
    {
        if ($score === 21) {
            $this->updateSaldo(-$betAmount, $betAmount);
            return "Aj, Banken fick 21!";
        } elseif ($score >= $this->player->getScore()) {
            $this->updateSaldo(-$betAmount, $betAmount);
            return "Ajdå, Banken hade bättre kort!";
        }
        return "Bra, Du hade bättre kort än Banken!!!";
    }

    /**
     * @param Deck $deck - Deck object.
     * @param int $betAmount - Money the player has placed in the bet.
     * @return mixed - returns string with message if score is 21 or over 21,
     * else null, by calling method handlePlayerScore.
     *
     * While loop to deal the bank dealer cards until the points is over 16.
     * If score is over 21: calls method fixIfAcesInHand to lower score of Ace to 1.
     * If score still over 21: Calls method updateSaldo and returns a message.
     * After loop calls handleBankScore to get and return a proper message based on the score.
     */
    public function dealBank(Deck $deck, int $betAmount): mixed
    {
        while ($this->dealer->getScore() < 17) {
            $card = $this->dealer->deal($deck);
            $this->dealer->setCardHand($card);
            $points = $this->cardValues->getValue($card);
            $this->dealer->setScore($points);
            if ($this->dealer->getScore() > 21) {
                if ($this->cardValues->fixIfAcesInHand($this->dealer) > 21) {
                    $this->updateSaldo($betAmount, -$betAmount);
                    return "Grattis, Banken fick över 21!!!";
                }
            }
        }
        $score = $this->dealer->getScore();
        return $this->handleBankScore($score, $betAmount);
    }

    /**
     * @return mixed - returns string with message if player or bank saldo is les than 1.
     * Else null to let the game continue.
     *
     * Check both player and bank saldo.
     */
    public function checkPlayerSaldo(): mixed
    {
        if ($this->player->getMoney() < 1) {
            return "GAME OVER. Dina pengar är slut.";
        }
        if ($this->dealer->getMoney() < 1) {
            return "GRATTIS DU VANN!!! Bankens pengar är slut.";
        }
        return null;
    }

    /**
     * @param $playeramount - bet amount to be changed for players saldo.
     * @param $dealeramount - bet amount to be changed for dealers saldo.
     * @return void
     *
     * Update both Player and Banks saldo.
     */
    public function updateSaldo(int $playerAmount, int $dealerAmount): void
    {
        $this->player->setMoney($playerAmount);
        $this->dealer->setMoney($dealerAmount);
    }
}
