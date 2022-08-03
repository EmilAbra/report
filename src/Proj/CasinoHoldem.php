<?php

/**
 * Module for CasinoHoldem class - poker game.
 *
 * @author Emil Abrahamsson <emilabrahamsson@yahoo.com>
 */

namespace App\Proj;
use App\Proj\Dealer;
use App\Proj\Player;

class CasinoHoldem
{
    /**
     * @var array $players - The players in the game.
     * @var object $dealer - The dealer of the game.
     * @var object $board - The board holding cards.
     */
    private array $players;
    private object $dealer;
    private object $board;

    /**
     * Constructor for the CasinoHoldem class.
     *
     * @param array<object> $players - The players in the game.
     * @param object $dealer - The dealer of the game.
     */
    public function __construct(array $players, Dealer $dealer, Board $board)
    {
        $this->players = $players;
        $this->dealer = $dealer;
        $this->board = $board;
    }

    /**
     * Get the $players array.
     *
     * @return array<object> $players.
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * Get the $dealer object.
     *
     * @return Dealer - $dealer.
     */
    public function getDealer(): object
    {
        return $this->dealer;
    }

    /**
     * Get the $board object.
     *
     * @return Board - $board.
     */
    public function getBoard(): object
    {
        return $this->board;
    }

    /**
     * Start first round of Casino Holdem.
     *
     * @return void
     */
    public function startFirstRound(): void
    {
        foreach ($this->getPlayers() as $player) {
            $this->getDealer()->deal($player, 2);
        }
        $this->getDealer()->deal($this->getBoard(), 3);
    }

    /**
     * Start second round of Casino Holdem.
     *
     * @return void
     */
    public function startSecondRound(): void
    {
        $this->getDealer()->deal($this->getBoard(), 2);
        $this->getBoard()->shareCardsWithPlayers($this->getPlayers());
    }

    // /**
    //  * Decide winner of round.
    //  *
    //  * @param array<mixed> $playerHandValue - The players hand value.
    //  * @param array<mixed> $aiHandValue - The a.i. hand value.
    //  * @return string - message of who won the round.
    //  */
    // public function decideWinner(array $playerHandValue, array $aiHandValue): string
    // {
    //     $this->getDealer()->deal($this->getBoard(), 2);
    //     $this->getBoard()->shareCardsWithPlayers($this->getPlayers());
    // }
}
