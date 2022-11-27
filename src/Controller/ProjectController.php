<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\PlayerInfo;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PlayerInfoRepository;
use App\Repository\PayTableRepository;
use App\Proj\Deck;
use App\Proj\Dealer;
use App\Proj\Player;
use App\Proj\Board;
use App\Proj\CasinoHoldem;
use App\Proj\HandValue;

class ProjectController extends AbstractController
{
    #[Route('/proj', name: 'app_project')]
    public function index(PlayerInfoRepository $playerInfoRepository, SessionInterface $session): Response
    {
        $playerInfo = $playerInfoRepository
            ->find(1);
        $aiPlayerInfo = $playerInfoRepository
            ->find(2);

        if (empty($playerInfo) || empty($aiPlayerInfo)) {
                throw $this->createNotFoundException(
                    'Player not found in database'
                );
        }
        $session->set("playerInfo", $playerInfo);
        $session->set("aiPlayerInfo", $aiPlayerInfo);

        $data = [
            'playerInfo' => $playerInfo,
            'aiPlayerInfo' => $aiPlayerInfo
        ];
        return $this->render('project/index.html.twig', $data);
    }

    /**
     * @Route("/proj/deal", name="deal_flopp")
     */
    public function dealFlopp(PayTableRepository $payTableRepository, SessionInterface $session): Response
    {
        $playerInfo = $session->get("playerInfo");
        $aiPlayerInfo = $session->get("aiPlayerInfo");
        $payTable = $payTableRepository
            ->findAll();

        $player = new Player();
        $aiPlayer = new Player();
        $players = [$player, $aiPlayer];
        $deck = new Deck();
        $dealer = new Dealer($deck);
        $board = new Board();
        $casinoHoldem = new CasinoHoldem($players, $dealer, $board);
        $session->set("casinoHoldem", $casinoHoldem);
        $session->set("player", $player);
        $session->set("aiPlayer", $aiPlayer);
        $session->set("board", $board);
        $session->set("payTable", $payTable);
        $casinoHoldem->startFirstRound();

        $data = [
            'playerInfo' => $playerInfo,
            'playerHand' => $player->getCardHand(),
            'aiPlayerInfo' => $aiPlayerInfo,
            'aiPlayerHand' => $aiPlayer->getCardHand(),
            'boardCards' => $board->getCardHand(),
            'payTable' => $payTable
        ];
        return $this->render('project/deal_flopp.html.twig', $data);
    }

    /**
     * @Route("/proj/fold", name="fold")
     */
    public function playerFold(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $playerInfo = $session->get("playerInfo");
        $aiInfo = $session->get("aiPlayerInfo");
        $player = $session->get("player");
        $aiPlayer = $session->get("aiPlayer");
        $board = $session->get("board");
        $payTable = $session->get("payTable");

        $callAmount = 200;
        $playerSaldo = $playerInfo->getSaldo();
        $playerInfo->setSaldo($playerSaldo - $callAmount);
        $aiSaldo = $aiInfo->getSaldo();
        $aiInfo->setSaldo($aiSaldo + $callAmount);

        $entityManager->flush();

        $data = [
            'playerInfo' => $playerInfo,
            'playerHand' => $player->getCardHand(),
            'aiPlayerInfo' => $aiInfo,
            'aiPlayerHand' => $aiPlayer->getCardHand(),
            'boardCards' => $board->getCardHand(),
            'payTable' => $payTable
        ];
        return $this->render('project/fold.html.twig', $data);
    }

    /**
     * @Route("/proj/call", name="deal_river")
     */
    public function dealRiver(SessionInterface $session): Response
    {
        $playerInfo = $session->get("playerInfo");
        $aiInfo = $session->get("aiPlayerInfo");
        $casinoHoldem = $session->get("casinoHoldem");
        $player = $session->get("player");
        $aiPlayer = $session->get("aiPlayer");
        $board = $session->get("board");
        $payTable = $session->get("payTable");

        $casinoHoldem->startSecondRound();
        $playerHand = $player->getCardHand();
        $handValue = new HandValue();
        $playerHandValue = $handValue->findHandValue($playerHand);

        $session->set("playerHandValue", $playerHandValue);
        $session->set("handValue", $handValue);

        $data = [
            'playerInfo' => $playerInfo,
            'playerHand' => $playerHand,
            'playerHandValue' => $playerHandValue,
            'aiPlayerInfo' => $aiInfo,
            'aiPlayerHand' => $aiPlayer->getCardHand(),
            'boardCards' => $board->getCardHand(),
            'payTable' => $payTable
        ];
        return $this->render('project/deal_river.html.twig', $data);
    }

    /**
     * @Route("/proj/call/show_ai_cards", name="show_ai_cards")
     */
    public function showAiCards(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $playerInfo = $session->get("playerInfo");
        $aiInfo = $session->get("aiPlayerInfo");
        $casinoHoldem = $session->get("casinoHoldem");
        $player = $session->get("player");
        $aiPlayer = $session->get("aiPlayer");
        $board = $session->get("board");
        $playerHandValue = $session->get("playerHandValue");
        $handValue = $session->get("handValue");
        $payTable = $session->get("payTable");

        $aiHand = $aiPlayer->getCardHand();
        $aiHandValue = $handValue->findHandValue($aiHand);

        $winnerMessage = $casinoHoldem->decideWinner($playerHandValue, $aiHandValue);
        $playerSaldo = $playerInfo->getSaldo();
        $aiSaldo = $aiInfo->getSaldo();
        $payouts = $casinoHoldem->calculateWinnings($winnerMessage, $playerHandValue, $aiHandValue);
        $playerInfo->setSaldo($playerSaldo + $payouts["player"]);
        $aiInfo->setSaldo($aiSaldo + $payouts["aiPlayer"]);
        $maxPayouts = max(array_slice($payouts, 0, 2));
        $message = "{$winnerMessage} $" . "{$maxPayouts} utbetalas för {$payouts["hand"]}.";

        $entityManager->flush();
        $data = [
            'playerInfo' => $playerInfo,
            'playerHand' => $player->getCardHand(),
            'playerHandValue' => $playerHandValue,
            'aiPlayerInfo' => $aiInfo,
            'aiPlayerHand' => $aiHand,
            'aiHandValue' => $aiHandValue,
            'boardCards' => $board->getCardHand(),
            'message' => $message,
            'payTable' => $payTable
        ];
        return $this->render('project/show_ai_cards.html.twig', $data);
    }

    /**
     * @Route("/proj/reset", name="reset_project")
     */
    public function reset(PlayerInfoRepository $playerInfoRepository): Response
    {   
        $playerInfo = $playerInfoRepository
            ->find(1);
        $aiPlayerInfo = $playerInfoRepository
            ->find(2);
        $playerInfo->setSaldo(10000);
        $aiPlayerInfo->setSaldo(10000);

        return $this->redirectToRoute('app_project');
    }

    /**
     * @Route("/proj/about", name="about_project")
     */
    public function about(): Response
    {
        return $this->render('project/about.html.twig');
    }
}
