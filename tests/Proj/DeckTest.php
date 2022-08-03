<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Deck.
 */
class DeckTest extends TestCase
{
    /**
     * Setup object to be tested in all cases.
     */
    public function setUp(): void
    {
        $this->deck = new Deck();
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeck(): void
    {
        $this->assertInstanceOf("\App\Proj\Deck", $this->deck);

        $deck = $this->deck->getDeck();
        $this->assertInstanceOf("\App\Proj\Card", $deck[0]);
        $this->assertEquals(count($deck), 52);
    }

    /**
     * Test setDeck adds Card object.
     */
    public function testSetDeckAddsCardObject(): void
    {
        $ace = new Card('spades', 'A', 14);
        $this->deck->setDeck($ace);
        $cards = $this->deck->getDeck();
        $this->assertInstanceOf("\App\Proj\Card", end($cards));
    }

    /**
     * test resetDeck sets empty array.
     */
    public function testResetDeckSetsEmptyArray(): void
    {
        $this->deck->resetDeck();

        $this->assertEquals($this->deck->getDeck(), []);
    }

    /**
     * test shuffle Deck is still array.
     */
    public function testShuffleDeckIsStillArray(): void
    {
        $this->deck->shuffle();
        $shuffledArray = $this->deck->getDeck();
        $this->assertTrue(is_array($shuffledArray));
    }

    /**
     * test drawCard returns array with Card object.
     */
    public function testDrawCardsReturnsArrayWithCardObjects(): void
    {
        $twoCards = $this->deck->drawCards(2);
        $this->assertInstanceOf("\App\Proj\Card", $twoCards[0]);
        $this->assertEquals(count($twoCards), 2);
    }

    /**
     * test getRanks returns array with right strings.
     */
    public function testGetRanksReturnsRightStringArray(): void
    {
        $ranks = $this->deck->getRanks();
        $cardRanks = [
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            'J',
            'Q',
            'K',
            'A'
        ];
        $this->assertEquals($ranks, $cardRanks);
    }

    /**
     * test getSuits returns array with right strings.
     */
    public function testGetSuitsReturnsRightStringArray(): void
    {
        $suits = $this->deck->getSuits();
        $cardSuits = [
            'diams',
            'hearts',
            'spades',
            'clubs'
        ];
        $this->assertEquals($suits, $cardSuits);
    }

    /**
     * test getValues returns array with right integers.
     */
    public function testGetValuesReturnsRightIntArray(): void
    {
        $values = $this->deck->getValues();
        $cardValues = [
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14
        ];
        $this->assertEquals($values, $cardValues);
    }


    /**
     * test getNumberOfCards returns right number of cards in Deck.
     */
    public function testGetNumberOfCardsReturnsRightNumberOfCardsInDeck(): void
    {
        $this->assertEquals($this->deck->getNumberOfCards(), 52);
    }
}
