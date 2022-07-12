<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Routing\Annotation\Route;

class CardControllerJson extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="json_deck")
     */
    public function jsonDeck(SerializerInterface $serializer): JsonResponse
    {
        $deck = new \App\Card\Deck();

        foreach ($deck->getSuits() as $suit) {
            foreach ($deck->getRanks() as $rank) {
                $card = new \App\Card\Card($suit, $rank);
                $deck->setDeck($card);
            }
        }
        $data = $serializer->serialize($deck, JsonEncoder::FORMAT);
        $response = new JsonResponse($data, Response::HTTP_OK, [], true);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }
}
