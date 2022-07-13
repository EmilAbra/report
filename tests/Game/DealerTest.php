<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Game\Deck;

/**
 * Test cases for class Dealer.
 */
class DealerTest extends TestCase
{
    /**
     * Setup object to be tested in all cases.
     */
    public function setUp(): void
    {
        $this->dealer = new Dealer();
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $this->assertInstanceOf("\App\Game\Dealer", $this->dealer);
    }

    /**
     * Test method deal returns a Card object.
     */
    public function testDealReturnsCardObject(): void
    {
        $deck = new Deck();
        $deck->setupDeck();

        $this->assertInstanceOf("\App\Game\Card", $this->dealer->deal($deck));
    }

}
