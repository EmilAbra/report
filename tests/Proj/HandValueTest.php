<?php

namespace App\Proj;

use App\Proj\Card;
use App\Proj\Hand;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class HandValue.
 */
class HandValueTest extends TestCase
{
    /**
     * Setup object to be tested in the cases.
     */
    public function setUp(): void
    {
        $this->handValue = new HandValue();
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateHandValue(): void
    {
        $this->assertInstanceOf("\App\Proj\HandValue", $this->handValue);
    }

    /**
     * Test handHasPair returns right value.
     */
    public function testHandHasPairReturnsRightValue(): void
    {
        $pairArray = array(2,2,5,3,4,5,2);
        $this->assertEquals($this->handValue->handHasPair($pairArray), 5);

        $noPairArray = array(2,2,6,3,4,5,2);
        $this->assertFalse($this->handValue->handHasPair($noPairArray));
    }

    /**
     * Test handHasTwoPair returns array with the two pair ranks.
     */
    public function testHandHasTwoPairReturnsRightValues(): void
    {
        $twoPairArray = array(2,2,5,1,4,5,3);
        $this->assertIsArray($this->handValue->handHasTwoPair($twoPairArray));

        $rankArray = $this->handValue->handHasTwoPair($twoPairArray);
        $this->assertTrue(in_array(2, $rankArray));
        $this->assertTrue(in_array(5, $rankArray));
    }

    /**
     * Test handHasTwoPair returns array with the right two pair ranks if
     * 3 pairs in hand.
     */
    public function testHandHasTwoPairReturnsRightValuesIfThreePairs(): void
    {
        $threePairArray = array(2,2,5,1,3,5,3);
        $this->assertIsArray($this->handValue->handHasTwoPair($threePairArray));

        $rankArray = $this->handValue->handHasTwoPair($threePairArray);
        $this->assertTrue(in_array(3, $rankArray));
        $this->assertTrue(in_array(5, $rankArray));
        $this->assertFalse(in_array(2, $rankArray));
    }

    /**
     * Test handHasTwoPair returns False if not a two pair.
     */
    public function testHandHasTwoPairReturnsFalse(): void
    {
        $noPairArray = array(2,2,6,3,4,5,2);
        $this->assertFalse($this->handValue->handHasTwoPair($noPairArray));

        $onePairArray = array(2,2,6,3,4,5,1);
        $this->assertFalse($this->handValue->handHasTwoPair($onePairArray));
    }

    /**
     * Test handHasThreeOfAKind returns right value.
     */
    public function testHandHasThreeOfAKindReturnsRightValue(): void
    {
        $threeArray = array(2,2,2,1,4,5,3);
        $this->assertEquals($this->handValue->handHasThreeOfAKind($threeArray), 2);
    }

    /**
     * Test handHasThreeOfAKind returns False.
     */
    public function testHandHasThreeOfAKindReturnsFalse(): void
    {
        $onePairArray = array(2,2,6,3,4,5,1);
        $this->assertFalse($this->handValue->handHasThreeOfAKind($onePairArray));
    }

    /**
     * Test handHasFlush returns flush array with values.
     */
    public function testHandHasFlushReturnsRightValues(): void
    {
        $flushCards = [
            new Card("diams", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("diams", "6", 6)
        ];

        $flushArray = $this->handValue->handHasFlush($flushCards);
        $this->assertIsArray($flushArray);
        $this->assertTrue(in_array(2, $flushArray));
        $this->assertTrue(in_array(6, $flushArray));
    }

    /**
     * Test handHasFlush returns False if not flush.
     */
    public function testHandHasFlushReturnsFalse(): void
    {
        $noFlushArray = [
            new Card("clubs", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("diams", "6", 6)
        ];

        $this->assertFalse($this->handValue->handHasFlush($noFlushArray));
    }

    /**
     * Test handHasStraight returns highest rank value in straight.
     */
    public function testHandHasStraightReturnsRightValue(): void
    {
        $straightArray = [
            2,
            3,
            4,
            5,
            6,
            13,
            14
        ];
        $this->assertEquals($this->handValue->handHasStraight($straightArray), 6);
    }

    /**
     * Test handHasStraight converts Ace to 1 for low straight and returns
     * right value.
     */
    public function testHandHasStraightReturnsRightValueWithAce(): void
    {
        $straightArray = [
            2,
            3,
            4,
            5,
            9,
            13,
            14
        ];
        $this->assertEquals($this->handValue->handHasStraight($straightArray), 5);
    }

    /**
     * Test handHasStraight returns right value if seven card straight.
     */
    public function testHandHasStraightReturnsRightValueWithSevenCardStraight(): void
    {
        $straightArray = [
            2,
            3,
            4,
            5,
            6,
            7,
            8
        ];
        $this->assertEquals($this->handValue->handHasStraight($straightArray), 8);
    }

    /**
     * Test handHasFullHouse returns right rank of the Three Of a Kind.
     */
    public function testhandHasFullHouseReturnsRightValue(): void
    {
        $fullHouseArray = [
            2,
            2,
            2,
            5,
            6,
            5,
            8
        ];
        $this->assertEquals($this->handValue->handHasFullHouse($fullHouseArray), 2);
    }

    /**
     * Test handHasFullHouse returns False when no * full house.
     */
    public function testhandHasFullHouseReturnsFalse(): void
    {
        $fullHouseArray = [
            2,
            2,
            6,
            5,
            6,
            5,
            8
        ];
        $this->assertFalse($this->handValue->handHasFullHouse($fullHouseArray));
    }

    /**
     * Test handHasFourOfAKind returns right rank of the Four Of a Kind.
     */
    public function testhandHasFourOfAKindReturnsRightValue(): void
    {
        $fourArray = [
            2,
            2,
            2,
            2,
            6,
            5,
            8
        ];
        $this->assertEquals($this->handValue->handHasFourOfAKind($fourArray), 2);
    }

    /**
     * Test handHasFourOfAKind returns False if not Four Of a Kind.
     */
    public function testhandHasFourOfAKindReturnsFalse(): void
    {
        $notFourArray = [
            2,
            2,
            2,
            6,
            6,
            5,
            8
        ];
        $this->assertFalse($this->handValue->handHasFourOfAKind($notFourArray));
    }

    /**
     * Test findHandValue returns array with right value when hand is Royal
     * Flush.
     */
    public function testFindHandValueReturnsRoyalFlushValue(): void
    {
        $royalArray = [
            new Card("diams", "10", 10),
            new Card("diams", "J", 11),
            new Card("diams", "Q", 12),
            new Card("diams", "K", 13),
            new Card("diams", "A", 14)
        ];

        $royalValue = $this->handValue->findHandValue($royalArray);

        $this->assertIsArray($royalValue);
        $this->assertEquals($royalValue['Royal Flush'], 14);
    }

    /**
     * Test findHandValue returns array with right value when hand is straight
     * Flush.
     */
    public function testFindHandValueReturnsStraightFlushValue(): void
    {
        $straightFlushArray = [
            new Card("diams", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("diams", "A", 14),
            new Card("daims", "K", 13),
            new Card("clubs", "A", 14)
        ];

        $straightFlushValue = $this->handValue->findHandValue($straightFlushArray);

        $this->assertIsArray($straightFlushValue);
        $this->assertEquals($straightFlushValue['Färgstege'], 5);
    }

    /**
     * Test findHandValue returns array with right value when hand is Four of
     * a Kind.
     */
    public function testFindHandValueReturnsFourOfAKindValue(): void
    {
        $fourArray = [
            new Card("diams", "2", 2),
            new Card("clubs", "2", 2),
            new Card("spades", "2", 2),
            new Card("hearts", "2", 2),
            new Card("diams", "A", 14)
        ];

        $fourValue = $this->handValue->findHandValue($fourArray);

        $this->assertIsArray($fourValue);
        $this->assertEquals($fourValue['Fyrtal'], 2);
    }

    /**
     * Test findHandValue returns array with right value when hand is Full
     * House.
     */
    public function testFindHandValueReturnsFullHouseValue(): void
    {
        $fullHouseArray = [
            new Card("diams", "2", 2),
            new Card("clubs", "2", 2),
            new Card("spades", "A", 14),
            new Card("hearts", "A", 14),
            new Card("diams", "A", 14)
        ];

        $fullHouseValue = $this->handValue->findHandValue($fullHouseArray);

        $this->assertIsArray($fullHouseValue);
        $this->assertEquals($fullHouseValue['Kåk'], 14);
    }

    /**
     * Test findHandValue returns array with highest value when hand is Flush.
     */
    public function testFindHandValueReturnsFlushValue(): void
    {
        $flushArray = [
            new Card("diams", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("diams", "K", 13)
        ];

        $flushValue = $this->handValue->findHandValue($flushArray);

        $this->assertIsArray($flushValue);
        $this->assertEquals($flushValue['Färg'], 13);
    }

    /**
     * Test findHandValue returns array with highest straight value when
     * hand is straight.
     */
    public function testFindHandValueReturnsStraightValue(): void
    {
        $straightArray = [
            new Card("diams", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("clubs", "6", 6),
            new Card("clubs", "7", 7),
            new Card("clubs", "A", 14)
        ];

        $straightValue = $this->handValue->findHandValue($straightArray);

        $this->assertIsArray($straightValue);
        $this->assertEquals($straightValue['Stege'], 7);
    }

    /**
     * Test findHandValue returns array with rank of Three of a Kind.
     */
    public function testFindHandValueReturnsThreeOfAKindValue(): void
    {
        $threeArray = [
            new Card("diams", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("clubs", "2", 2),
            new Card("spades", "2", 2),
            new Card("clubs", "K", 13)
        ];

        $threeValue = $this->handValue->findHandValue($threeArray);

        $this->assertIsArray($threeValue);
        $this->assertEquals($threeValue['Triss'], 2);
    }

    /**
     * Test findHandValue returns array with high pair and low pair rank.
     */
    public function testFindHandValueReturnsTwoPairValues(): void
    {
        $twoPairArray = [
            new Card("diams", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("clubs", "2", 2),
            new Card("spades", "3", 3),
            new Card("clubs", "K", 13)
        ];

        $twoPairValues = $this->handValue->findHandValue($twoPairArray);

        $this->assertIsArray($twoPairValues);
        $this->assertEquals($twoPairValues['Tvåpar'], [2, 3]);
    }

    /**
     * Test findHandValue returns array with pair rank.
     */
    public function testFindHandValueReturnsPairValue(): void
    {
        $pairArray = [
            new Card("diams", "8", 8),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("clubs", "2", 2),
            new Card("spades", "K", 13),
            new Card("clubs", "K", 13)
        ];

        $pairValue = $this->handValue->findHandValue($pairArray);

        $this->assertIsArray($pairValue);
        $this->assertEquals($pairValue['Par'], 13);
    }

    /**
     * Test findHandValue returns zero value when no hand.
     */
    public function testFindHandValueReturnsZeroWhenNoHand(): void
    {
        $noHandArray = [
            new Card("diams", "8", 8),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("clubs", "2", 2),
            new Card("spades", "Q", 12),
            new Card("clubs", "K", 13)
        ];

        $zeroValue = $this->handValue->findHandValue($noHandArray);

        $this->assertEquals($zeroValue['Inget'], 0);
    }
}
