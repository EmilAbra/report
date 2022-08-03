<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;
use App\Proj\Deck;
use App\Proj\Player;

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
        $this->deck = new Deck();
        $this->dealer = new Dealer($this->deck);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $this->assertInstanceOf("\App\Proj\Dealer", $this->dealer);
    }

    /**
     * Test method deal returns array with Card objects.
     */
    public function testDealSetsPlayerHandWithCardObjects(): void
    {
        $hand = new Hand();
        $player = new Player($hand);
        $this->dealer->deal($player, 2);
        $cardHand = $player->getCardHand();
        $this->assertIsArray($cardHand);
        $this->assertEquals(count($cardHand), 2);
        $this->assertInstanceOf("\App\Proj\Card", $cardHand[0]);
    }
}
