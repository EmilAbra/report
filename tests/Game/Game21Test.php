<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class Game21Test extends TestCase
{
    /**
     * Setup objects to be used in the test cases.
     */
    public function setUp(): void
    {
        $this->deck = new Deck();
        $this->dealer = new Dealer();
        $this->player = new Player();
        $this->cardValues = new Game21CardValues();
        $this->dealerHand = new DealerHand($this->deck);
        $this->game21 = new Game21($this->dealer, $this->player, $this->cardValues, $this->dealerHand);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGame21(): void
    {
        $this->assertInstanceOf("\App\Game\Game21", $this->game21);

        $this->assertInstanceOf("\App\Game\Dealer", $this->dealer);

        $this->assertInstanceOf("\App\Game\Player", $this->player);

        $this->assertInstanceOf("\App\Game\Game21CardValues", $this->cardValues);

        $this->assertInstanceOf("\App\Game\DealerHand", $this->dealerHand);
    }

    /**
     * test handlePlayerScore returns right message when hand score is 21.
     */
    public function testHandlePlayerScoreReturnsRightStringHandIs21(): void
    {
        $this->assertEquals($this->game21->handlePlayerScore(21, 100), "Du fick 21!!! Grattis du vann denna omgången!");
    }

    /**
     * test handlePlayerScore returns right message when hand score is over 21.
     */
    public function testHandlePlayerScoreReturnsRightStringHandIsOver21(): void
    {
        $cards = [new Card('spades', 'K'), new Card('spades', '7'), new Card('hearts', 'K')];
        $player = $this->player;

        foreach ($cards as $card) {
            $player->setCardHand($card);
            $cardValue = $this->cardValues->getValue($card);
            $player->setScore($cardValue);
        }
        $playerScore = $player->getScore();

        $this->assertEquals($this->game21->handlePlayerScore($playerScore, 100), "Ajdå, Du fick över 21!");
    }

    /**
     * test handlePlayerScore returns null.
     */
    public function testHandlePlayerScoreReturnsNull(): void
    {
        $this->assertEquals($this->game21->handlePlayerScore(14, 100), null);
    }

    /**
     * test playerTurn returns right string when hand is 21.
     */
    public function testPlayerTurnReturnsRightStringHandIs21(): void
    {
        $player = $this->player;
        $player->setScore(14);
        $card = new Card('spades', '7');
        $this->deck->setDeck($card);

        $this->assertEquals($this->game21->playerTurn(100), "Du fick 21!!! Grattis du vann denna omgången!");
    }

    /**
     * test playerTurn returns null when hand is under 21.
     */
    public function testPlayerTurnReturnsNullWhenHandIsUnder21(): void
    {
        $player = $this->player;
        $player->setScore(14);
        $card = new Card('spades', '4');
        $this->deck->setDeck($card);

        $this->assertEquals($this->game21->playerTurn(100), null);
    }

    /**
     * test handleBankScore returns right message when hand score is 21.
     */
    public function testHandleBankScoreReturnsRightStringHandIs21(): void
    {
        $this->assertEquals($this->game21->handleBankScore(21, 100), "Aj, Banken fick 21!");
    }

    /**
     * test handleBankScore returns right message when bank hand score is better or equal than players hand score.
     */
    public function testHandleBankScoreReturnsRightStringHandIsBetterThanPlayer(): void
    {
        $player = $this->player;
        $player->setScore(14);
        $this->assertEquals($this->game21->handleBankScore(14, 100), "Ajdå, Banken hade bättre kort!");

        $this->assertEquals($this->game21->handleBankScore(15, 100), "Ajdå, Banken hade bättre kort!");
    }

    /**
     * test handleBankScore returns right message when hand score is weaker than players hand score.
     */
    public function testHandleBankScoreReturnsRightStringHandIsWeakerThanPlayer(): void
    {
        $player = $this->player;
        $player->setScore(14);

        $this->assertEquals($this->game21->handleBankScore(13, 100), "Bra, Du hade bättre kort än Banken!!!");
    }

    /**
     * test BankTurn returns right message when hand score is weaker than players hand score.
     */
    public function testBankTurnAddCardsWhenScoreIsUnder17(): void
    {
        $cards = [new Card('spades', '5'), new Card('spades', '4'), new Card('spades', '6'), new Card('hearts', '6')];
        $deck = $this->deck;
        foreach ($cards as $card) {
            $deck->setDeck($card);
        }

        $this->assertEquals($this->game21->bankTurn(100), "Aj, Banken fick 21!");
    }

    /**
     * test BankTurn returns right message when card score is over 21.
     */
    public function testBankTurnReturnsCorrectMessageWhenCardScoreIsOver21(): void
    {
        $cards = [new Card('spades', 'K'), new Card('spades', '6'), new Card('hearts', '6')];
        $deck = $this->deck;
        foreach ($cards as $card) {
            $deck->setDeck($card);
        }

        $this->assertEquals($this->game21->bankTurn(100), "Grattis, Banken fick över 21!!!");
    }
}
