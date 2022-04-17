<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class JsonCardController extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="json_deck")
     */
    public function jsonDeck(): Response
    {
        $deck = new \App\Card\Deck();

        foreach($deck->getSuits() as $suit) {
            foreach ($deck->getRanks() as $rank) {
                $card = new \App\Card\Card($suit, $rank);
                $deck->setDeck($card);
            }
        }

        return $this->render('card/json_deck.html.twig');
    }
}
