<?php

/**
 * Module for card hand value - playing cards.
 *
 * @author Emil Abrahamsson <emilabrahamsson@yahoo.com>
 */

namespace App\Proj;

use App\Proj\Card;
use App\Proj\Hand;

class HandValue
{
    /**
     * Constructor for the HandValue class.
     */
    public function __construct()
    {
    }

    /**
     * Check if hand has a pair.
     *
     * @param array<int> $cardValues - card hand values.
     * @return mixed - rank value of the pair or false if no pair.
     */
    public function handHasPair(array $cardValues): mixed
    {
        $countValues = array_count_values($cardValues);
        foreach ($countValues as $value => $amount) {
            if ($amount === 2) {
                return $value;
            }
        }
        return false;
    }

    /**
     * Check if hand has a two pairs.
     *
     * @param array<int> $cardValues - card hand values.
     * @return mixed - rank value array of the high and low pair.
     * false if not two pair.
     */
    public function handHasTwoPair(array $cardValues): mixed
    {
        $countValues = array_count_values($cardValues);
        $rankArray = [];
        $counter = 0;
        foreach ($countValues as $value => $amount) {
            if ($amount === 2) {
                $rankArray[] = $value;
                $counter += 1;
            }
        }
        if ($counter === 3) {
            sort($rankArray);
            array_shift($rankArray);
        }
        if (count($rankArray) === 2) {
            return $rankArray;
        }
        return false;
    }

    /**
     * Check if hand has three of a kind.
     *
     * @param array<int> $cardValues - card hand values.
     * @return mixed - rank value of the Three cards
     * or false if no three of a kind.
     */
    public function handHasThreeOfAKind(array $cardValues): mixed
    {
        $countValues = array_count_values($cardValues);
        foreach ($countValues as $value => $amount) {
            if ($amount === 3) {
                return $value;
            }
        }
        return false;
    }

    /**
     * Check if hand has a flush.
     *
     * @param array<object> $cardHand - Cards in hand.
     * @return mixed - highest value in the flush.
     * false if no flush in hand.
     */
    public function handHasFlush(array $cardHand): mixed
    {
        $countSuits = array_count_values($this->getAllSuits($cardHand));
        foreach ($countSuits as $suit => $amount) {
            if ($amount >= 5) {
                $flushValues = [];
                foreach ($cardHand as $card) {
                    if ($card->getSuit() === $suit) {
                        $flushValues[] = $card->getValue();
                    }
                }
                return $flushValues;
            }
        }
        return false;
    }

    /**
     * Check if Ace(14) is at first value in array and 5 in indexposition depending
     * on array size. If so convert Ace from 14 to 1.
     *
     * @param array<int> $cardValues - card hand values.
     * @return mixed - The highest card value in the straight or false if no
     * straight in hand.
     */
    public function convertAceIflowStraight($cards): array
    {
        rsort($cards);
        if (count($cards) === 7 && $cards[0] === 14 && $cards[3] === 5) {
            $cards[0] = 1;
        } elseif (count($cards) === 6 && $cards[0] === 14 && $cards[2] === 5) {
            $cards[0] = 1;
        } elseif (count($cards) === 5 && $cards[0] === 14 && $cards[1] === 5) {
            $cards[0] = 1;
        }
        sort($cards);
        return $cards;
    }

    /**
     * Check first if Ace in card by calling convertAceIflowStraight.
     * Count the cards after getting uniques and sorting. If the highest card
     * subtracted by the card 4 steps down in array is 4, then it is a
     * straight.
     *
     * @param array<int> $cardValues - card hand values.
     * @return mixed - The highest card value in the straight or false if no
     * straight in hand.
     */
    public function handHasStraight(array $cardValues): mixed
    {
        $cards = array_unique($cardValues);
        $cards = $this->convertAceIflowStraight($cards);

        if (count($cards) > 4) {
            if (count($cards) > 6) {
                if (($cards[6] - $cards[2]) == 4) {
                    $highestCard = $cards[6];
                    return $highestCard;
                }
            }
            if (count($cards) > 5) {
                if (($cards[5] - $cards[1]) == 4) {
                    $highestCard = $cards[5];
                    return $highestCard;
                }
            }
            if (($cards[4] - $cards[0]) == 4) {
                $highestCard = $cards[4];
                return $highestCard;
            }
        }
        return false;
    }

    /**
     * Check if hand has a Full House.
     *
     * @param array<int> $cardValues - card hand values.
     * @return mixed - The rank of the Three of a kind in Full House.
     * false if no Full House.
     */
    public function handHasFullHouse(array $cardValues): mixed
    {
        $countValues = array_count_values($cardValues);
        if (in_array(3, $countValues) && in_array(2, $countValues)) {
            foreach ($countValues as $value => $amount) {
                if ($amount === 3) {
                    return $value;
                }
            }
        }
        return false;
    }

    /**
     * Check if hand has Four Of a Kind.
     *
     * @param array<int> $cardValues - card hand values.
     * @return mixed - The rank of the four of a Kind.
     * false if not Four Of a Kind found.
     */
    public function handHasFourOfAKind(array $cardValues): mixed
    {
        $countValues = array_count_values($cardValues);
        foreach ($countValues as $value => $amount) {
            if ($amount === 4) {
                return $value;
            }
        }
        return false;
    }

    /**
     * Get all card values in hand.
     *
     * @param array<object> $cardHand - Cards in card hand.
     * @return array<int> VALUES
     */
    public function getAllValues(array $cardHand): array
    {
        $valuesArray = [];
        foreach ($cardHand as $card) {
            $valuesArray[] = $card->getValue();
        }
        return $valuesArray;
    }

    /**
     * Get all card suits in hand.
     *
     * @param array<object> $cardHand - Cards in card hand.
     * @return array<string> SUITS
     */
    public function getAllSuits(array $cardHand): array
    {
        $suitsArray = [];
        foreach ($cardHand as $card) {
            $suitsArray[] = $card->getSuit();
        }
        return $suitsArray;
    }

    /**
     * Main method to go through every possible hand.
     *
     * @param array<object> $cardHand - Cards in card hand.
     * @return array - Hand name and hand score out of the card hand in array.
     */
    public function findHandValue(array $cardHand): array
    {
        $cardValues = $this->getAllValues($cardHand);
        $handArray = [];

        $flushHandArray = $this->handHasFlush($cardHand);
        if ($flushHandArray) {
            $straightValue = $this->handHasStraight($flushHandArray);
            if ($straightValue === 14) {
                $handArray['Royal Flush'] = $straightValue;
                return $handArray;
            }
        }

        if ($flushHandArray) {
            $straightValue = $this->handHasStraight($flushHandArray);
            if ($straightValue) {
                $handArray['Färgstege'] = $straightValue;
                return $handArray;
            }
        }

        $fourValue = $this->handHasFourOfAKind($cardValues);
        if ($fourValue) {
            $handArray['Fyrtal'] = $fourValue;
            return $handArray;
        }

        $fullHouseValue = $this->handHasFullHouse($cardValues);
        if ($fullHouseValue) {
            $handArray['Kåk'] = $fullHouseValue;
            return $handArray;
        }

        if ($flushHandArray) {
            $handArray['Färg'] = max($flushHandArray);
            return $handArray;
        }

        $straightValue = $this->handHasStraight($cardValues);
        if ($straightValue) {
            $handArray['Stege'] = $straightValue;
            return $handArray;
        }

        $threeValue = $this->handHasThreeOfAKind($cardValues);
        if ($threeValue) {
            $handArray['Triss'] = $threeValue;
            return $handArray;
        }

        $twoPairValue = $this->handHasTwoPair($cardValues);
        if ($twoPairValue) {
            $handArray['Tvåpar'] = $twoPairValue;
            return $handArray;
        }

        $pairValue = $this->handHasPair($cardValues);
        if ($pairValue) {
            $handArray['Par'] = $pairValue;
            return $handArray;
        }
        $handArray['Inget'] = 0;
        return $handArray;
    }
}
