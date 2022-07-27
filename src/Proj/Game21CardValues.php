<?php

/**
 * Module for class Game21CardValues - cardgame.
 */

namespace App\Proj;

use App\Proj\Card;
use App\Proj\Deck;
use App\Proj\Dealer;
use App\Proj\Player;

class Game21CardValues
{
    /**
     * @var array<string|int> CARD_VALUES - Scores for each card rank in cardgame 21.
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
     * @param $player - Player or Dealer object.
     * @return int - the players score.
     *
     * Check if hand includes Ace and lowers its value to 1 if the total
     * is over 21. Returns the updated score.
     */
    public function fixIfAcesInHand(object $player): int
    {
        $cardCount = 0;
        $playerScore = $player->getScore();
        $playerHand = $player->getCardHand();
        $nrOfCardsInHand = count($playerHand);

        while ($playerScore > 21 and $cardCount < $nrOfCardsInHand) {
            if ($this->getValue($playerHand[$cardCount]) === 14 && !$playerHand[$cardCount]->isConvertedAce()) {
                $playerHand[$cardCount]->setConvertedAce();
                $player->setScore(-13);
                $cardCount += 1;
                continue;
            }
            $cardCount += 1;
        }
        return $player->getScore();
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
