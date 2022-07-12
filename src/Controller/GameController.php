<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Deck;
use App\Card\Dealer;
use App\Card\Player;
use App\Card\Game21;

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
        $game = new Game21($dealer, $player);

        $session->set("deck", $deck);
        $session->set("dealer", $dealer);
        $session->set("player", $player);
        $session->set("game", $game);

        $data = [
            'cardsLeft' => $deck->getNumberOfCards(),
            'playerMoney' => $player->getMoney(),
            'dealerMoney' => $dealer->getMoney()
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


        $dealCard = $game->dealPlayer($deck, $moneyAmount);
        $checkSaldo = $game->checkPlayerSaldo();
        if ($checkSaldo) {
            $dealCard = $checkSaldo;
        }
        $data = [
            'message' => $dealCard ?? null,
            'playerScore' => $player->getScore(),
            'dealerScore' => $dealer->getScore(),
            'playerMoney' => $player->getMoney(),
            'dealerMoney' => $dealer->getMoney(),
            'playerHand' => $player->getCardHand(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];
        if ($checkSaldo) {
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

        $dealCards = $game->dealBank($deck, $moneyAmount);
        $checkSaldo = $game->checkPlayerSaldo();
        if ($checkSaldo) {
            $dealCards = $checkSaldo;
        }

        $data = [
            'message' => $dealCards ?? null,
            'dealerScore' => $dealer->getScore(),
            'playerScore' => $player->getScore(),
            'dealerHand' => $dealer->getCardHand(),
            'playerHand' => $player->getCardHand(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];
        if ($checkSaldo) {
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
            'playerMoney' => $player->getMoney(),
            'dealerMoney' => $dealer->getMoney(),
            'playerHand' => $player->getCardHand(),
            'cardsLeft' => $deck->getNumberOfCards()
        ];

        return $this->render('game/deal_next.html.twig', $data);
    }
}
