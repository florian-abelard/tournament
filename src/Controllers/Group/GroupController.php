<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Group;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\MatchRepository;
use Flo\Tournoi\Domain\Group\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    private
        $groupRepository,
        $matchRepository;

    public function __construct(GroupRepository $groupRepository, MatchRepository $matchRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->matchRepository = $matchRepository;
    }

    public function viewDetailAction(string $uuid): Response
    {
        $group = $this->groupRepository->findById(new Uuid($uuid));

        $matches = $this->matchRepository->findByGroupId(new Uuid($uuid));

        $matches->sortByPosition();

        return $this->render('Group/showGroup.html.twig', array('group' => $group, 'matches' => $matches));
    }
}
