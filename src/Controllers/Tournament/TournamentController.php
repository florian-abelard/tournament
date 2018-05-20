<?php

namespace Flo\Tournoi\Controllers\Tournament;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Domain\Tournament\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TournamentController extends Controller
{
    private
        $tournamentRepository,
        $playerRepository;

    public function __construct(TournamentRepository $tournamentRepository, PlayerRepository $playerRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->playerRepository = $playerRepository;
    }

    public function displayList(): Response
    {
        $tournaments = $this->tournamentRepository->findAll();

        return $this->render('Tournament/listTournament.html.twig', array('tournaments' => $tournaments));
    }

    public function show(string $uuid): Response
    {
        $tournament = $this->tournamentRepository->findById(new Uuid($uuid));

        $tournamentPlayers = $this->playerRepository->findByTournamentId($tournament->uuid());

        return $this->render(
            'Tournament/showTournament.html.twig',
            array('tournament' => $tournament, 'players' => $tournamentPlayers)
        );
    }
}
