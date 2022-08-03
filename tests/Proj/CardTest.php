<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;
use App\Proj\Card;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Setup object to be tested in all cases.
     */
    public function setUp(): void
    {
        $this->card = new Card('spades', 'A', 14);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $this->assertInstanceOf("\App\Proj\Card", $this->card);
    }

    /**
     * Test getSuit returns right suit.
     */
    public function testGetSuitReturnsRightStringSuit(): void
    {
        $this->assertEquals($this->card->getSuit(), 'spades');
    }

    /**
    * Test getRank returns right rank.
    */
    public function testGetRankReturnsRightStringRank(): void
    {
        $this->assertEquals($this->card->getRank(), 'A');
    }

    /**
    * Test getValue returns right value.
    */
    public function testGetValueReturnsRightIntValue(): void
    {
        $this->assertEquals($this->card->getValue(), 14);
    }
}
