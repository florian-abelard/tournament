<?php

namespace Flo\Tournoi\Controllers\Tournament;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Registration\RegistrationRepository;
use Flo\Tournoi\Domain\Registration\Entities\Registration;
use Flo\Tournoi\Domain\Tournament\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TournamentController extends Controller
{
    private
        $tournamentRepository,
        $playerRepository,
        $registrationRepository;

    public function __construct(
        TournamentRepository $tournamentRepository,
        PlayerRepository $playerRepository,
        RegistrationRepository $registrationRepository
    ){
        $this->tournamentRepository = $tournamentRepository;
        $this->playerRepository = $playerRepository;
        $this->registrationRepository = $registrationRepository;
    }

    public function list(): Response
    {
        $tournaments = $this->tournamentRepository->findAll();

        return $this->render('Tournament/listTournament.html.twig', array('tournaments' => $tournaments));
    }

    public function detail(string $uuid): Response
    {
        $tournament = $this->tournamentRepository->findById(new Uuid($uuid));

        $participatingPlayers = $this->playerRepository->findByTournamentId($tournament->uuid());

        $players = $this->playerRepository->findNotInTournament($tournament->uuid());

        return $this->render(
            'Tournament/showTournament.html.twig',
            array(
                'tournament' => $tournament,
                'participatingPlayers' => $participatingPlayers,
                'players' => $players
            )
        );
    }

    public function addPlayer(Request $request, string $uuid): Response
    {
        $playerUuid = $request->request->get('player_to_add');

        $registration = new Registration(new Uuid($playerUuid), new Uuid($uuid));

        $this->registrationRepository->persist($registration);

        return $this->redirectToRoute('tournoi_tournament_detail', ['uuid' => $uuid]);
    }
}
