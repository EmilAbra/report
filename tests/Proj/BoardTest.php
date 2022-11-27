<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;
use App\Proj\Card;
use App\Proj\Hand;

/**
 * Test cases for class Board.
 */
class BoardTest extends TestCase
{
    /**
     * Setup object to be tested in all cases.
     */
    public function setUp(): void
    {
        $this->hand1 = new Hand();
        $this->player1 = new Player($this->hand1);
        $this->hand2 = new Hand();
        $this->player2 = new Player($this->hand2);
        $this->players = [$this->player1, $this->player2];
        $this->hand3 = new Hand();
        $card = new Card("spades", "A", 14);
        $this->hand3->setDeck($card);
        $this->board = new Board();
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateBoard(): void
    {
        $this->assertInstanceOf("\App\Proj\Board", $this->board);
    }

    /**
     * Test method shareCardsWithPlayers adds board cards to
     * players card hands.
     */
    // public function testShareCardsWithPlayersAddsCardsToPlayerHands(): void
    // {
    //     $this->board->shareCardsWithPlayers($this->players);
    //     $cardHand = $this->player1->getCardHand();
    //     echo $cardHand[0];
    //     $this->assertInstanceOf("\App\Proj\Card", $cardHand[0]);
    //     $this->assertEquals(count($cardHand), 1);
    // }
}
