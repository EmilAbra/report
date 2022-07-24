<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game21CardValues.
 */
class Game21CardValuesTest extends TestCase
{
    /**
     * Setup object to be tested in all cases.
     */
    public function setUp(): void
    {
        $this->cardValues = new Game21CardValues();
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGame21CardValues(): void
    {
        $this->assertInstanceOf("\App\Game\Game21CardValues", $this->cardValues);
    }

    /**
     * test fixIfAcesInHand returns right score with one ace in hand.
     */
    public function testfixIfAcesInHandReturnsRightScoreForOneAce(): void
    {
        $cards = [new Card('spades', 'K'), new Card('spades', '7'), new Card('spades', 'A')];
        $player = new Player();

        foreach ($cards as $card) {
            $player->setCardHand($card);
            $cardValue = $this->cardValues->getValue($card);
            $player->setScore($cardValue);
        }
        $this->cardValues->fixIfAcesInHand($player);

        $this->assertEquals($player->getScore(), 21);
    }

    /**
     * test fixIfAcesInHand returns right score with two aces in hand.
     */
    public function testfixIfAcesInHandReturnsRightScoreForTwoAces(): void
    {
        $cards = [new Card('spades', 'K'), new Card('spades', '6'), new Card('spades', 'A'), new Card('hearts', 'A')];
        $player = new Player();

        foreach ($cards as $card) {
            $player->setCardHand($card);
            $cardValue = $this->cardValues->getValue($card);
            $player->setScore($cardValue);
        }
        $this->cardValues->fixIfAcesInHand($player);

        $this->assertEquals($player->getScore(), 21);
    }

    /**
     * test fixIfAcesInHand with no cards in hand.
     */
    public function testfixIfAcesInHandWithNoCards(): void
    {
        $player = new Player();

        $this->cardValues->fixIfAcesInHand($player);

        $this->assertEquals($player->getScore(), 0);
    }


    /**
     * test getValue returns correct integer value.
     */
    public function testGetValueReurnsCorrectValue(): void
    {
        $card = new Card('spades', '5');
        $this->assertEquals($this->cardValues->getValue($card), 5);

        $card = new Card('spades', 'A');
        $this->assertEquals($this->cardValues->getValue($card), 14);
    }
}
