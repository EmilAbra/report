<?php

namespace App\Game;

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
    public function testCreateCard(): void
    {
        $this->assertInstanceOf("\App\Game\Deck", $this->deck);

        $this->assertEquals($this->deck->getDeck(), []);
    }

    /**
     * Test setDeck adds Card object.
     */
    public function testSetDeckAddsCardObject(): void
    {
        $ace = new Card('spades', 'A');
        $this->deck->setDeck($ace);
        $card = $this->deck->getDeck();
        $this->assertInstanceOf("\App\Game\Card", $card[0]);
    }

    /**
     * test SetupDeck includes 52 Items.
     */
    public function testSetupDeckIncludes52Items(): void
    {
        $this->deck->setupDeck();
        $nrOfCards = count($this->deck->getDeck());

        $this->assertEquals($nrOfCards, 52);
    }

    /**
     * test SetupDeck has Card objects.
     */
    public function testSetupDeckHasCardObjects(): void
    {
        $this->deck->setupDeck();
        $deck = $this->deck->getDeck();

        $this->assertInstanceOf("\App\Game\Card", $deck[0]);
        $this->assertInstanceOf("\App\Game\Card", end($deck));
    }

    /**
     * test redetDeck sets empty array.
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
     * test drawCard returns Card object.
     */
    public function testDrawCardReturnsCardObject(): void
    {
        $this->deck->setupDeck();
        $oneCard = $this->deck->drawCard();
        $this->assertInstanceOf("\App\Game\Card", $oneCard);
    }

    /**
     * test getRanks returns array with right strings.
     */
    public function testGetRanksReturnsProperArray(): void
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
    public function testGetSuitsReturnsProperArray(): void
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
     * test getNumberOfCards returns right number of cards in Deck.
     */
    public function testGetNumberOfCardsReturnsRightNumberOfCardsInDeck(): void
    {
        $this->deck->setupDeck();
        $this->assertEquals($this->deck->getNumberOfCards(), 52);
    }
}
