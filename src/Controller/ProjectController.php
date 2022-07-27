<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PlayerRepository;

class ProjectController extends AbstractController
{
    #[Route('/proj', name: 'app_project')]
    public function index(PlayerRepository $playerRepository, SessionInterface $session): Response
    {
        $player = $playerRepository
            ->find(1);
        $aiPlayer = $playerRepository
            ->find(2);

        if (empty($player) || empty($aiPlayer)) {
                throw $this->createNotFoundException(
                    'Player not found in database'
                );
        }
        $session->set("player", $player);
        $session->set("aiPlayer", $aiPlayer);

        $data = [
            'player' => $player,
            'aiPlayer' => $aiPlayer
        ];
        return $this->render('project/index.html.twig', $data);
    }

    /**
     * @Route("/proj/about", name="about_project")
     */
    public function about(): Response
    {
        return $this->render('project/about.html.twig');
    }
}
