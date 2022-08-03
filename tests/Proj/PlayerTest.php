<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;
use App\Proj\Card;
use App\Proj\Hand;

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
        $this->hand = new Hand();
        $this->player = new Player($this->hand);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $this->assertInstanceOf("\App\Proj\Player", $this->player);
    }

    /**
     * Test method setCardHand appends Card objects to players cardhand and
     * getCardHand returns array with card object.
     */
    public function testSetCardHandAddsCardObject(): void
    {
        $card = new Card('spades', 'A', 14);
        $this->player->setCardHand($card);
        $cardHand = $this->player->getCardHand();
        $this->assertInstanceOf("\App\Proj\Card", $cardHand[0]);
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
        $cards = [new Card('spades', 'K', 13), new Card('spades', '7', 7), new Card('spades', 'A', 14)];
        foreach ($cards as $card) {
            $this->player->setCardHand($card);
        }
        $this->player->resetCardhand();
        $cardHand = $this->player->getCardHand();
        $this->assertIsArray($cardHand);
        $this->assertEmpty($cardHand);
    }
}
