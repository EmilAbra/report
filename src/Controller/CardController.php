<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function shuffle(): Response
    {
        $deck = new \App\Card\Deck();
        $ranks = $deck->getRanks();
        $suits = $deck->getSuits();

        foreach($suits as $suit) {
            foreach ($ranks as $rank) {
                $card = new \App\Card\Card($suit, $rank);
                $deck->addCard($card);
            }
        }
        $deck->shuffle();

        $data = [
            'deck' => $deck
        ];
        return $this->render('card/shuffle.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw")
     */
    public function draw(): Response
    {
        return $this->render('card/draw.html.twig');
    }

    /**
     * @Route("/card/deck/draw/:number", name="draw_many")
     */
    public function draw_many(): Response
    {
        return $this->render('card/draw_many.html.twig');
    }

    /**
     * @Route("/card/deck/deal/:players/:cards", name="draw_with_players")
     */
    public function draw_with_players(): Response
    {
        return $this->render('card/draw_with_players.html.twig');
    }

    /**
     * @Route("/card/deck2", name="deck_with_jokers")
     */
    public function deck_with_jokers(): Response
    {
        return $this->render('card/deck_with_jokers.html.twig');
    }
}
