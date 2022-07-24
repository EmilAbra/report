<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Game\Deck;
use App\Game\Dealer;
use App\Game\Player;
use App\Game\Game21;
use App\Game\Game21CardValues;
use App\Game\DealerHand;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="card_game")
     */
    public function info(): Response
    {
        return $this->render('game/info.html.twig');
    }

    /**
     * @Route("/game/doc", name="doc")
     */
    public function documentation(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    /**
     * @Route("/game/play", name="play")
     */
    public function play(SessionInterface $session): Response
    {
        $deck = new Deck();
        $deck->setupDeck();
        $deck->shuffle();
        $dealer = new Dealer();
        $player = new Player();
        $cardValues = new Game21CardValues();
        $dealerHand = new DealerHand($deck);
        $game = new Game21($dealer, $player, $cardValues, $dealerHand);

        $session->set("deck", $deck);
        $session->set("dealer", $dealer);
        $session->set("player", $player);
        $session->set("game", $game);

        $data = [
            'cardsLeft' => $deck->getNumberOfCards(),
            'playerMoney' => $player->getSaldo(),
            'dealerMoney' => $dealer->getSaldo()
        ];
        return $this->render('game/play.html.twig', $data);
    }

    /**
     * @Route("/game/deal", name="deal_player", methods={"GET"})
     */
    public function dealPlayer(Request $request, SessionInterface $session): Response
    {
        $deck = $session->get("deck");
        $dealer = $session->get("dealer");
        $player = $session->get("player");
        $game = $session->get("game");
        if ($request->query->get('moneyAmount')) {
            $moneyAmount = $request->query->get('moneyAmount');
            $session->set("moneyAmount", $moneyAmount);
        }
        $moneyAmount = $session->get("moneyAmount");

        $dealCard = $game->playerTurn($moneyAmount);

        $checkPlayerSaldo = $player->isSaldoEmpty();
        $checkDealerSaldo = $dealer->isSaldoEmpty();
        if ($checkPlayerSaldo) {
            $dealCard = "GAME OVER. Dina pengar är slut.";
        }
        if ($checkDealerSaldo) {
            $dealCard = "GRATTIS DU VANN!!! Bankens pengar är slut.";
        }

        $data = [
            'message' => $dealCard ?? null,
            'playerScore' => $player->getScore(),
            'dealerScore' => $dealer->getScore(),
            'playerMoney' => $player->getSaldo(),
            'dealerMoney' => $dealer->getSaldo(),
            'playerHand' => $player->getCardHand(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];
        if ($checkPlayerSaldo || $checkDealerSaldo) {
            return $this->render('game/end.html.twig', $data);
        }
        if ($player->getScore() >= 21) {
            return $this->render('game/result.html.twig', $data);
        }
        return $this->render('game/deal_player.html.twig', $data);
    }

    /**
     * @Route("/game/deal/bank", name="deal_bank")
     */
    public function dealBank(SessionInterface $session): Response
    {
        $deck = $session->get("deck");
        $dealer = $session->get("dealer");
        $player = $session->get("player");
        $game = $session->get("game");
        $moneyAmount = $session->get("moneyAmount");

        $dealCard = $game->bankTurn($moneyAmount);
        $checkPlayerSaldo = $player->isSaldoEmpty();
        $checkDealerSaldo = $dealer->isSaldoEmpty();
        if ($checkPlayerSaldo) {
            $dealCard = "GAME OVER. Dina pengar är slut.";
        }
        if ($checkDealerSaldo) {
            $dealCard = "GRATTIS DU VANN!!! Bankens pengar är slut.";
        }

        $data = [
            'message' => $dealCard ?? null,
            'dealerScore' => $dealer->getScore(),
            'playerScore' => $player->getScore(),
            'dealerHand' => $dealer->getCardHand(),
            'playerHand' => $player->getCardHand(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];
        if ($checkPlayerSaldo || $checkDealerSaldo) {
            return $this->render('game/end.html.twig', $data);
        }
        return $this->render('game/result.html.twig', $data);
    }

    /**
     * @Route("/game/deal_next", name="deal_next")
     */
    public function dealNext(SessionInterface $session): Response
    {
        $deck = $session->get("deck");
        $dealer = $session->get("dealer");
        $player = $session->get("player");

        $dealer->resetCardhand();
        $player->resetCardhand();
        $dealer->resetScore();
        $player->resetScore();
        $deck->resetDeck();
        $deck->setupDeck();
        $deck->shuffle();
        $session->set("deck", $deck);
        $data = [
            'playerScore' => $player->getScore(),
            'dealerScore' => $dealer->getScore(),
            'playerMoney' => $player->getSaldo(),
            'dealerMoney' => $dealer->getSaldo(),
            'playerHand' => $player->getCardHand(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];

        return $this->render('game/deal_next.html.twig', $data);
    }
}
