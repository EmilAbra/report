<?php

namespace App\Proj;

use App\Proj\Card;
use App\Proj\Hand;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Hand.
 */
class HandTest extends TestCase
{
    /**
     * Setup object to be tested in the cases.
     */
    public function setUp(): void
    {
        $cardArray = [
            new Card("diams", "2", 2),
            new Card("diams", "3", 3),
            new Card("diams", "4", 4),
            new Card("diams", "5", 5),
            new Card("diams", "6", 6)
        ];
        $this->hand = new Hand();
        foreach ($cardArray as $card) {
            $this->hand->setDeck($card);
        }
    }

    /**
    * Construct object and verify that the object has the expected
    * properties, use no arguments.
    */
    public function testCreateHand(): void
    {
        $this->assertInstanceOf("\App\Proj\Hand", $this->hand);
    }

    /**
     * Test getAllRanks returns array with correct strings.
     */
    public function testGetAllRanks(): void
    {
        $handRanks = $this->hand->getAllRanks();
        $this->assertIsArray($handRanks);
        $this->assertContains("2", $handRanks);
    }

    /**
     * Test getAllSuits returns array with correct strings.
     */
    public function testGetAllSuits(): void
    {
        $handRanks = $this->hand->getAllSuits();
        $this->assertIsArray($handRanks);
        $this->assertContains("diams", $handRanks);
    }

    /**
     * Test getAllValues returns array with correct integers.
     */
    public function testGetAllValues(): void
    {
        $handRanks = $this->hand->getAllValues();
        $this->assertIsArray($handRanks);
        $this->assertContains(2, $handRanks);
    }


}
