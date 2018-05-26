<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Player;

use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PlayerController extends Controller
{
    private
        $playerRepository;

    public function __construct(PlayerRepository $repository)
    {
        $this->playerRepository = $repository;
    }

    public function viewCreate(): Response
    {
        return $this->render('Player/createPlayer.html.twig');
    }

    public function create(Request $request): Response
    {
        $name = $request->request->get('name');

        $player = new Player(
            new Uuid(),
            $name
        );

        $this->playerRepository->persist($player);

        return $this->render('Player/createPlayer.html.twig');
    }

    public function list(): Response
    {
        $players = $this->playerRepository->findAll();

        return $this->render('Player/listPlayer.html.twig', array('players' => $players));
    }

    public function remove(string $uuid): RedirectResponse
    {
        $this->playerRepository->remove(new Uuid($uuid));

        return $this->redirectToRoute('tournoi_player_list');
    }
}
