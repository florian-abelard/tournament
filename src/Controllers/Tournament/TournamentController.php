<?php

namespace Flo\Tournoi\Controllers\Tournament;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Domain\Tournament\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TournamentController extends Controller
{
    private
        $tournamentRepository;

    public function __construct(TournamentRepository $repository)
    {
        $this->tournamentRepository = $repository;
    }

    public function displayList(): Response
    {
        $tournaments = $this->tournamentRepository->findAll();

        return $this->render('Tournament/listTournament.html.twig', array('tournaments' => $tournaments));
    }

    public function show(string $uuid): Response
    {
        $tournament = $this->tournamentRepository->findById(new Uuid($uuid));

        return $this->render('Tournament/showTournament.html.twig', array('tournament' => $tournament));
    }
}
