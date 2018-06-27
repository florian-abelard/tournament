<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Stage;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\GroupRepository;
use Flo\Tournoi\Domain\Stage\StageRepository;
use Flo\Tournoi\Domain\Stage\Entities\Stage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StageController extends Controller
{
    private
        $stageRepository,
        $groupRepository;

    public function __construct(StageRepository $stageRepository, GroupRepository $groupRepository)
    {
        $this->stageRepository = $stageRepository;
        $this->groupRepository = $groupRepository;
    }

    public function viewDetailAction(string $uuid): Response
    {
        $stage = $this->stageRepository->findById(new Uuid($uuid));

        if ($stage->type() == Stage::TYPE_GROUP)
        {
            $groups = $this->groupRepository->findByStageId(new Uuid($uuid));

            return $this->render('Stage/showGroupStage.html.twig', array('stage' => $stage, 'groups' => $groups));
        }
    }
}
