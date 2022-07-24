<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DealerHand.
 */
class DealerHandTest extends TestCase
{
    /**
     * Setup objects to be tested in the cases.
     */
    public function setUp(): void
    {
        $this->deck = new Deck();
        $this->deck->setupDeck();
        $this->dealerHand = new DealerHand($this->deck);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGame21(): void
    {
        $this->assertInstanceOf("\App\Game\Deck", $this->deck);

        $this->assertInstanceOf("\App\Game\DealerHand", $this->dealerHand);
    }

    /**
     * Test method DealPlayer returns Card object from this Deck.
     */
    public function testDealPlayerReturnsCardFromTheDeck(): void
    {
        $dealer = new Dealer();
        $this->assertInstanceOf("\App\Game\Card", $this->dealerHand->dealPlayer($dealer));
    }
}
