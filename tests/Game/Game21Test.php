<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class Game21Test extends TestCase
{
    /**
     * Setup object to be tested in all cases.
     */
    public function setUp(): void
    {
        $dealer = new Dealer();
        $player = new Player();
        $cardValues = new Game21CardValues();
        $this->game21 = new Game21($dealer, $player, $cardValues);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGame21(): void
    {
        $this->assertInstanceOf("\App\Game\Game21", $this->game21);

        $this->assertInstanceOf("\App\Game\Dealer", $this->game21->getDealer());

        $this->assertInstanceOf("\App\Game\Player", $this->game21->getPlayer());
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
        $player = $this->game21->getPlayer();

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
     * test DealPlayer returns right string when hand is 21.
     */
    public function testDealPlayerReturnsRightStringHandIs21(): void
    {
        $player = $this->game21->getPlayer();
        $player->setScore(14);
        $card = new Card('spades', '7');
        $deck = new Deck();
        $deck->setDeck($card);

        $this->assertEquals($this->game21->dealPlayer($deck, 100), "Du fick 21!!! Grattis du vann denna omgången!");
    }

    /**
     * test DealPlayer returns null when hand is under 21.
     */
    public function testDealPlayerReturnsNullWhenHandIsUnder21(): void
    {
        $player = $this->game21->getPlayer();
        $player->setScore(14);
        $card = new Card('spades', '4');
        $deck = new Deck();
        $deck->setDeck($card);

        $this->assertEquals($this->game21->dealPlayer($deck, 100), null);
    }

    /**
     * test handleBankScore returns right message when hand score is 21.
     */
    public function testHandleBankScoreReturnsRightStringHandIs21(): void
    {
        $this->assertEquals($this->game21->handleBankScore(21, 100), "Aj, Banken fick 21!");
    }

    /**
     * test handleBankScore returns right message when hand score is better or equal than players hand score.
     */
    public function testHandleBankScoreReturnsRightStringHandIsBetterThanPlayer(): void
    {
        $player = $this->game21->getPlayer();
        $player->setScore(14);
        $this->assertEquals($this->game21->handleBankScore(14, 100), "Ajdå, Banken hade bättre kort!");

        $this->assertEquals($this->game21->handleBankScore(15, 100), "Ajdå, Banken hade bättre kort!");
    }

    /**
     * test handleBankScore returns right message when hand score is weaker than players hand score.
     */
    public function testHandleBankScoreReturnsRightStringHandIsWeakerThanPlayer(): void
    {
        $player = $this->game21->getPlayer();
        $player->setScore(14);

        $this->assertEquals($this->game21->handleBankScore(13, 100), "Bra, Du hade bättre kort än Banken!!!");
    }

    /**
     * test handleBankScore returns right message when hand score is weaker than players hand score.
     */
    public function testDealBankAddCardsWhenScoreIsUnder17(): void
    {
        $cards = [new Card('spades', '5'), new Card('spades', '4'), new Card('spades', '6'), new Card('hearts', '6')];
        $deck = new Deck();
        foreach ($cards as $card) {
            $deck->setDeck($card);
        }

        $this->assertEquals($this->game21->dealBank($deck, 100), "Aj, Banken fick 21!");
    }

    /**
     * test handleBankScore returns right message when card score is over 21.
     */
    public function testDealBankReturnsCorrectMessageWhenCardScoreIsOver21(): void
    {
        $cards = [new Card('spades', 'K'), new Card('spades', '6'), new Card('hearts', '6')];
        $deck = new Deck();
        foreach ($cards as $card) {
            $deck->setDeck($card);
        }

        $this->assertEquals($this->game21->dealBank($deck, 100), "Grattis, Banken fick över 21!!!");
    }

    /**
     * test checkPlayerSaldo returns right message when player saldo is under 1.
     */
    public function testCheckPlayerSaldoWhenPlayerIsUnder1(): void
    {
        $player = $this->game21->getPlayer();
        $player->setMoney(-100);

        $this->assertEquals($this->game21->checkPlayerSaldo(), "GAME OVER. Dina pengar är slut.");
    }

    /**
     * test checkPlayerSaldo returns right message when dealer saldo is under 1.
     */
    public function testCheckPlayerSaldoWhenDealerIsUnder1(): void
    {
        $dealer = $this->game21->getDealer();
        $dealer->setMoney(-100);

        $this->assertEquals($this->game21->checkPlayerSaldo(), "GRATTIS DU VANN!!! Bankens pengar är slut.");
    }

    /**
     * test checkPlayerSaldo returns null when all saldos i over 1.
     */
    public function testCheckPlayerSaldoWhenOver1(): void
    {
        $this->assertEquals($this->game21->checkPlayerSaldo(), null);
    }

    /**
     * test updateSaldo sets correct values.
     */
    public function testUpdateSaldoSetsCorrectValues(): void
    {
        $this->game21->updateSaldo(50, -50);
        $player = $this->game21->getPlayer();
        $this->assertEquals($player->getMoney(), 150);

        $dealer = $this->game21->getDealer();
        $this->assertEquals($dealer->getMoney(), 50);
    }
}
