<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Stage;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Group\GroupRepository;
use Flo\Tournoi\Domain\Stage\StageRepository;
use Flo\Tournoi\Domain\Stage\ValueObjects\StageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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

        var_dump($stage);

        if ($stage->type() == StageType::TYPE_GROUP)
        {
            $groups = $this->groupRepository->findByStageId(new Uuid($uuid));

            return $this->render('Stage/showGroupStage.html.twig', array('stage' => $stage, 'groups' => $groups));
        }
    }
}
