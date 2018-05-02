<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Player;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;

class PlayerController extends Controller
{
    private
        $playerRepository;

    public function __construct(PlayerRepository $repository)
    {
        $this->playerRepository = $repository;
    }

    public function displayAddForm()
    {
        return $this->render('Player/addPlayer.html.twig');
    }

    public function submitAddForm(Request $request): Response
    {
        $name = $request->request->get('name');

        $player = new Player(
            new Uuid(),
            $name
        );

        $this->playerRepository->persist($player);

        return $this->render('Player/addPlayer.html.twig');
    }

    public function displayList()
    {
        $players = $this->playerRepository->findAll();

        return $this->render('Player/listPlayer.html.twig', array('players' => $players));
    }

    public function remove(string $uuid)
    {
        $this->playerRepository->remove(new Uuid($uuid));

        return $this->redirectToRoute('tournoi_player_list');
    }
}
