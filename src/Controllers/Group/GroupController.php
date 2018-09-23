<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Group;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Game\GameRepository;
use Flo\Tournoi\Domain\Group\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    private
        $groupRepository,
        $gameRepository;

    public function __construct(GroupRepository $groupRepository, GameRepository $gameRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->gameRepository = $gameRepository;
    }

    public function viewDetailAction(string $uuid): Response
    {
        $group = $this->groupRepository->findById(new Uuid($uuid));

        // $players = $this->

        $games = $this->gameRepository->findByGroupId(new Uuid($uuid));
        // echo "<pre>";
        // var_dump($games);
        // echo "</pre>";
        $games->sortByPosition();

        return $this->render('Group/showGroup.html.twig', array('group' => $group, 'games' => $games));
    }
}
