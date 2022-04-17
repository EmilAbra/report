<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card_game")
     */
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    /**
     * @Route("/card/deck", name="deck")
     */
    public function deck(): Response
    {
        $deck = new \App\Card\Deck();
        $data = [
            'card_ranks' => $deck->getRanks(),
            'card_suits' => $deck->getSuits()
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffle")
     */
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new \App\Card\Deck();

        foreach($deck->getSuits() as $suit) {
            foreach ($deck->getRanks() as $rank) {
                $card = new \App\Card\Card($suit, $rank);
                $deck->setDeck($card);
            }
        }
        $deck->shuffle();
        $session->set("deck", $deck);

        $data = [
            'deck' => $deck
        ];
        return $this->render('card/shuffle.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw", methods={"GET","HEAD"})
     */
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? 0;
        $card = $deck->drawCard();
        $cardsLeft = $deck->getNumberOfCards();
        $session->set("deck", $deck);
        $data = [
            "card" => $card,
            "cardsLeft" => $cardsLeft
        ];
        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw/{number}", name="draw_many", methods={"GET","HEAD"})
     */
    public function draw_many(int $number, SessionInterface $session): Response
    {
        $deck = $session->get("deck") ?? 0;
        $cards = $deck->drawMany($number);
        $cardsLeft = $deck->getNumberOfCards();
        $session->set("deck", $deck);
        $data = [
            "cards" => $cards,
            "cardsLeft" => $cardsLeft
        ];
        return $this->render('card/draw_many.html.twig', $data);
    }

    /**
     * @Route("/card/deck/deal", name="deal", methods={"GET","HEAD"})
     */
    public function deal(): Response
    {
        return $this->render('card/deal.html.twig');
    }

    /**
     * @Route("/card/deck/deal", name="deal-process", methods={"POST"})
     */
    public function dealProcess(Request $request): Response
    {
        $players = $request->request->get('players');
        $cards  = $request->request->get('cards');

        return $this->redirectToRoute('draw_with_players', array('players' => $players, 'cards' => $cards));
    }

    /**
     * @Route("/card/deck/deal/{players}/{cards}", name="draw_with_players")
     */
    public function draw_with_players(int $players, int $cards): Response
    {
        $deck = new \App\Card\Deck();
        foreach($deck->getSuits() as $suit) {
            foreach ($deck->getRanks() as $rank) {
                $card = new \App\Card\Card($suit, $rank);
                $deck->setDeck($card);
            }
        }
        $deck->shuffle();

        $gamePlayers = [];
        for ($i = 1; $i <= $players; $i++) {
            $hand = new \App\Card\CardHand($deck->drawMany($cards));
            $player = new \App\Card\Player($hand);
            $gamePlayers[] = $player;
        }
        // echo gettype($gamePlayers[0]);
        // echo <pre>; var_dump($gamePlayers); echo </pre>;
        $cardsLeft = $deck->getNumberOfCards();
        $data = [
            "players" => $gamePlayers,
            "cardsLeft" => $cardsLeft
        ];
        return $this->render('card/draw_with_players.html.twig', $data);
    }

    /**
     * @Route("/card/deck2", name="deck_with_jokers")
     */
    public function deck_with_jokers(): Response
    {
        $deck = new \App\Card\DeckWith2Jokers();

        $data = [
            'card_ranks' => $deck->getRanks(),
            'card_suits' => $deck->getSuits(),
            'jranks' => $deck::JRANKS,
            'jsuit' => $deck::JSUIT
        ];
        return $this->render('card/deck_with_jokers.html.twig', $data);
    }
}
