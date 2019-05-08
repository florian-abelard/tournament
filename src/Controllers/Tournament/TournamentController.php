<?php

namespace Flo\Tournoi\Controllers\Tournament;

use Doctrine\DBAL\Connection;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\MatchRepository;
use Flo\Tournoi\Domain\Match\Factories\GroupMatchCollectionFactory;
use Flo\Tournoi\Domain\Group\GroupRepository;
use Flo\Tournoi\Domain\Group\Factories\GroupCollectionFactory;
use Flo\Tournoi\Domain\Player\PlayerRepository;
use Flo\Tournoi\Domain\Registration\RegistrationRepository;
use Flo\Tournoi\Domain\Registration\Entities\Registration;
use Flo\Tournoi\Domain\Stage\StageRepository;
use Flo\Tournoi\Domain\Stage\Entities\GroupStage;
use Flo\Tournoi\Domain\Tournament\TournamentRepository;
use Flo\Tournoi\Domain\Tournament\Entities\Tournament;
use Flo\Tournoi\Domain\Tournament\ValueObjects\TournamentStatus;
use Flo\Tournoi\Persistence\Core\MysqlTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TournamentController extends Controller
{
    use MysqlTrait;

    private
        $tournamentRepository,
        $playerRepository,
        $registrationRepository,
        $groupRepository,
        $stageRepository,
        $matchRepository,
        $groupCollectionFactory,
        $groupMatchCollectionFactory;

    public function __construct(
        Connection $databaseConnection,
        TournamentRepository $tournamentRepository,
        PlayerRepository $playerRepository,
        RegistrationRepository $registrationRepository,
        GroupRepository $groupRepository,
        StageRepository $stageRepository,
        MatchRepository $matchRepository,
        GroupCollectionFactory $groupCollectionFactory,
        GroupMatchCollectionFactory $groupMatchCollectionFactory
    ){
        $this->databaseConnection = $databaseConnection;
        $this->tournamentRepository = $tournamentRepository;
        $this->playerRepository = $playerRepository;
        $this->registrationRepository = $registrationRepository;
        $this->groupRepository = $groupRepository;
        $this->stageRepository = $stageRepository;
        $this->matchRepository = $matchRepository;
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->groupMatchCollectionFactory = $groupMatchCollectionFactory;
    }

    public function viewCreate(): Response
    {
        return $this->render('Tournament/createTournament.html.twig');
    }

    public function create(Request $request): Response
    {
        $name = $request->request->get('name');

        $tournament = new Tournament(
            new Uuid(),
            $name,
            new TournamentStatus('upcoming')
        );

        $this->tournamentRepository->persist($tournament);

        return $this->render('Tournament/createTournament.html.twig');
    }

    public function list(): Response
    {
        $tournaments = $this->tournamentRepository->findAll();

        return $this->render('Tournament/listTournament.html.twig', array('tournaments' => $tournaments));
    }

    public function detail(string $uuid): Response
    {
        $tournament = $this->tournamentRepository->findById(new Uuid($uuid));

        $stages = $this->stageRepository->findByTournamentId($tournament->uuid());

        $registeredPlayers = $this->playerRepository->findByTournamentId($tournament->uuid());

        $notRegisteredplayers = $this->playerRepository->findNotInTournament($tournament->uuid());

        return $this->render(
            'Tournament/showTournament.html.twig',
            array(
                'tournament' => $tournament,
                'stages' => $stages,
                'registeredPlayers' => $registeredPlayers,
                'notRegisteredPlayers' => $notRegisteredplayers
            )
        );
    }

    public function remove(string $uuid): RedirectResponse
    {
        $this->tournamentRepository->remove(new Uuid($uuid));

        return $this->redirectToRoute('tournoi_tournament_list');
    }

    public function addPlayer(Request $request, string $uuid): Response
    {
        $playerUuid = $request->request->get('player_to_add');

        if ($playerUuid)
        {
            $registration = new Registration(new Uuid($playerUuid), new Uuid($uuid));

            $this->registrationRepository->persist($registration);
        }

        return $this->redirectToRoute('tournoi_tournament_detail', ['uuid' => $uuid]);
    }

    public function launch(string $uuid): Response
    {
        $this->startTransaction();

        try
        {
            $tournamentUuid = new Uuid($uuid);

            $this->tournamentRepository->updateStatus($tournamentUuid, new TournamentStatus('running'));

            $players = $this->playerRepository->findByTournamentId($tournamentUuid);

            $groupStage = new GroupStage(
                new Uuid(),
                $tournamentUuid
            );
            $groupStage->setNumberOfPlacesInGroup(4); // TODO dynamic numberOfPlacesInGroup
            $this->stageRepository->persist($groupStage);

            $groups = $this->groupCollectionFactory->create($players, $groupStage);
            foreach ($groups as $group)
            {
                $this->groupRepository->persist($group);

                $matches = $this->groupMatchCollectionFactory->create($group);
                foreach ($matches as $match)
                {
                    $this->matchRepository->persist($match);
                }
            }

            $this->commitTransaction();
        }
        catch (\Exception $e)
        {
            $this->rollbackTransaction();

            return $this->redirectToRoute('tournoi_tournament_detail', ['uuid' => $uuid]);
        }

        return $this->redirectToRoute('tournoi_stage_detail', ['uuid' => $groupStage->uuid()]);
    }
}
