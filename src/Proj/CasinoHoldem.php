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
     * @var array<mixed> CARD_ODDS - card hand decimal odds value.
     */
    private const CARD_ODDS = [
        'Royal Flush' => 101,
        'Färgstege' => 21,
        'Fyrtal' => 11,
        'Kåk' => 4,
        'Färg' => 3,
        'Stege' => 1,
        'Triss' => 1,
        'Tvåpar' => 1,
        'Par' => 1,
        'Inget' => 0
    ];

    /**
     * @var array<mixed> CARD_RANK - card hand Ranks.
     */
    private const CARD_RANK = [
        'Royal Flush' => 9,
        'Färgstege' => 8,
        'Fyrtal' => 7,
        'Kåk' => 6,
        'Färg' => 5,
        'Stege' => 4,
        'Triss' => 3,
        'Tvåpar' => 2,
        'Par' => 1,
        'Inget' => 0
    ];

    /**
     * @var array<object> $players - The players in the game.
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
     * @param $dealer - The dealer of the game.
     * @param $board - The game board.
     */
    public function __construct(array $players, Dealer $dealer, Board $board)
    {
        $this->players = $players;
        $this->dealer = $dealer;
        $this->board = $board;
    }

    /**
     * Get odds from CARD_ODDS array.
     *
     * @param string $cardValue - card hand name.
     * @return int the card value odds.
     */
    public function getCardOdds(string $cardValue): int
    {
        return self::CARD_ODDS[$cardValue];
    }

    /**
     * Get card rank from CARD_RANK array.
     *
     * @param string $cardValue - card hand name.
     * @return int the card rank.
     */
    public function getCardRank(string $cardValue): int
    {
        return self::CARD_RANK[$cardValue];
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

    /**
     * Compare Two pairs if both players has it.
     *
     * @param array<int> $playerCardValues - two pair array.
     * @param array<int> $aiCardValues - two pair array.
     * @return string - message of who won the round.
     */
    public function compareTwoPairs(array $playerCardValues, array $aiCardValues): string
    {
        sort($playerCardValues);
        sort($aiCardValues);
        if ($playerCardValues === $aiCardValues) {
            return "Oavgjort!";
        } elseif (max($playerCardValues) === max($aiCardValues)) {
            if (min($playerCardValues) > min($aiCardValues)) {
                return "Spelaren vinner!";
            }
            return "Datorn vinner!";
        } elseif (max($playerCardValues) > max($aiCardValues)) {
            return "Spelaren vinner!";
        }
        return "Datorn vinner!";
    }

    /**
     * Decide winner of round.
     *
     * @param array<mixed> $playerHandValues - The players hand value.
     * @param array<mixed> $aiHandValues - The a.i. hand value.
     * @return mixed - message of who won the round.
     */
    public function decideWinner(array $playerHandValues, array $aiHandValues): mixed
    {
        $playerHandName = array_keys($playerHandValues)[0];
        $aiHandName = array_keys($aiHandValues)[0];
        $playerHandCardRank = $this->getCardRank($playerHandName);
        $aiHandCardRank = $this->getCardRank($aiHandName);

        if ($playerHandCardRank > $aiHandCardRank) {
            return "Spelaren vinner!";
        } elseif ($playerHandCardRank < $aiHandCardRank) {
            return "Datorn vinner!";
        } elseif ($playerHandCardRank === $aiHandCardRank) {
            $playerCardValues = $playerHandValues[$playerHandName];
            $aiCardValues = $aiHandValues[$aiHandName];
            if ($playerHandName === 'Tvåpar') {
                return $this->compareTwoPairs($playerCardValues, $aiCardValues);
            }
            if ($playerCardValues > $aiCardValues) {
                return "Spelaren vinner!";
            } elseif ($playerCardValues < $aiCardValues) {
                return "Datorn vinner!";
            }
            return "Oavgjort!";
        }
        return null;
    }

    /**
     * Calculate the money to be payed and to whom.
     *
     * @param string $winnerMessage - winner message of who won.
     * @param array<mixed> $playerHandValues - The players hand value.
     * @param array<mixed> $aiHandValues - The a.i. hand value.
     * @return array<mixed> - message of who won the round.
     */
    public function calculateWinnings(
        string $winnerMessage,
        array $playerHandValues,
        array $aiHandValues
    ): array {
        $payoutArray = [];
        $callAmount = 200;
        $playerHand = array_keys($playerHandValues)[0];
        $aiHand = array_keys($aiHandValues)[0];
        if ($winnerMessage === "Spelaren vinner!") {
            $payouts = $callAmount * $this->getCardOdds($playerHand);
            $payoutArray["player"] = $payouts;
            $payoutArray["aiPlayer"] = -$payouts;
            $payoutArray["hand"] = $playerHand;
            return $payoutArray;
        } elseif ($winnerMessage === "Datorn vinner!") {
            $payouts = $callAmount * $this->getCardOdds($aiHand);
            $payoutArray["player"] = -$payouts;
            $payoutArray["aiPlayer"] = $payouts;
            $payoutArray["hand"] = $aiHand;
            return $payoutArray;
        }
        $payoutArray["player"] = 0;
        $payoutArray["aiPlayer"] = 0;
        $payoutArray["hand"] = $playerHand;
        return $payoutArray;
    }
}
