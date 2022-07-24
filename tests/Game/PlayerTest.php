<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Game\Card;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Setup object to be tested in all cases.
     */
    public function setUp(): void
    {
        $this->player = new Player();
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $this->assertInstanceOf("\App\Game\Player", $this->player);
    }

    /**
     * Test method setCardHand appends Card objects to players cardhand.
     */
    public function testSetCardHandAddsCardObject(): void
    {
        $cards = [new Card('spades', 'K'), new Card('spades', '7'), new Card('spades', 'A')];
        foreach ($cards as $card) {
            $this->player->setCardHand($card);
        }
        $cardHand = $this->player->getCardHand();

        $first = $cardHand[0];
        $this->assertInstanceOf("\App\Game\Card", $first);
    }

    /**
     * Test method getCardHand returns empty array when no cards.
     */
    public function testGetCardHandReturnsEmptyArray(): void
    {
        $cardHand = $this->player->getCardHand();
        $this->assertIsArray($cardHand);
        $this->assertEmpty($cardHand);
    }

    /**
     * Test method resetCardhand resets the cardhand array to empty.
     */
    public function testResetCardhandSetsCardHandToEmptyArray(): void
    {
        $cards = [new Card('spades', 'K'), new Card('spades', '7'), new Card('spades', 'A')];
        foreach ($cards as $card) {
            $this->player->setCardHand($card);
        }
        $this->player->resetCardhand();
        $cardHand = $this->player->getCardHand();
        $this->assertIsArray($cardHand);
        $this->assertEmpty($cardHand);
    }

    /**
     * Test method setScore and getScore is integer and get correct value.
     */
    public function testSetAndGetScoreIsIntValueAndGetCorrectValue(): void
    {
        $this->player->setScore(10);
        $this->player->setScore(2);
        $this->player->setScore(-2);
        $score = $this->player->getScore();
        $this->assertEquals($score, 10);
    }

    /**
     * Test method resetScore sets the cardScore to 0.
     */
    public function testResetScoreSetsTheCardScoreToZero(): void
    {
        $this->player->setScore(10);
        $this->player->resetScore();
        $score = $this->player->getScore();
        $this->assertEquals($score, 0);
    }

    /**
     * Test method setSaldo and getSaldo is integer and get correct value.
     */
    public function testSetAndGetSaldoIsIntValueAndGetCorrectValue(): void
    {
        $this->player->setSaldo(10);
        $this->player->setSaldo(2);
        $this->player->setSaldo(-2);
        $money = $this->player->getSaldo();
        $this->assertEquals($money, 110);
    }

    /**
     * Test method isSaldoEmpty on returns correct boolean.
     */
    public function testIsSaldoEmpty(): void
    {
        $this->player->setSaldo(-100);
        $this->assertTrue($this->player->isSaldoEmpty());

        $this->player->setSaldo(10);
        $this->assertFalse($this->player->isSaldoEmpty());
    }
}
