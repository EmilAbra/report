<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

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
        $this->card = new Card('spades', 'A');
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $this->assertInstanceOf("\App\Game\Card", $this->card);

        $this->assertEquals($this->card->getRank(), 'A');

        $this->assertEquals($this->card->getSuit(), 'spades');

        $this->assertFalse($this->card->isConvertedAce());
    }

    /**
     * Test setConvertedAce returns true.
     */
    public function testSetConvertedAceReturnTrue(): void
    {
        $this->card->setConvertedAce();

        $this->assertTrue($this->card->isConvertedAce());
    }
}
