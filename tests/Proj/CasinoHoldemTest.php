<?php

namespace App\Proj;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CasinoHoldem.
 */
class CasinoHoldemTest extends TestCase
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
        $this->deck = new Deck();
        $this->dealer = new Dealer($this->deck);
        $this->board = new Board($this->hand3, $this->players);
        $this->casinoHoldem = new CasinoHoldem($this->players, $this->dealer, $this->board);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCasinoHoldem(): void
    {
        $this->assertInstanceOf("\App\Proj\CasinoHoldem", $this->casinoHoldem);
    }

    /**
     * Test getPlayers returns array with Player objects.
     */
    public function testGetPlayersReturnsArrayWithPlayerObject(): void
    {
        $players = $this->casinoHoldem->getPlayers();
        $this->assertInstanceOf("\App\Proj\Player", $players[0]);
        $this->assertIsArray($players);
    }

    /**
     * Test getDealer returns Dealer object.
     */
    public function testGetDealerReturnsDealerObject(): void
    {
        $dealer = $this->casinoHoldem->getDealer();
        $this->assertInstanceOf("\App\Proj\Dealer", $dealer);
    }

    /**
     * Test getBoard returns Board object.
     */
    public function testGetBoardReturnsBoardObject(): void
    {
        $board = $this->casinoHoldem->getBoard();
        $this->assertInstanceOf("\App\Proj\Board", $board);
    }

    /**
     * Test startFirstRound adds 2 card objects players hands and 3 card
     * objects to the board.
     */
    public function testStartFirstRoundAddsCardsToPlayersAndBoard(): void
    {
        $this->casinoHoldem->startFirstRound();

        $players = $this->casinoHoldem->getPlayers();
        $player1 = $players[0];
        $player1Hand = $player1->getCardHand();
        $this->assertInstanceOf("\App\Proj\Card", $player1Hand[0]);
        $this->assertEquals(count($player1Hand), 2);

        $board = $this->casinoHoldem->getBoard();
        $boardCards = $board->getCardHand();
        $this->assertInstanceOf("\App\Proj\Card", $boardCards[0]);
        $this->assertEquals(count($boardCards), 3);
    }
}
