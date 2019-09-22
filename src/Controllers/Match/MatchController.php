<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Match;

use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;
use Flo\Tournoi\Domain\Match\MatchRepository;
use Flo\Tournoi\Domain\Match\ValueObjects\MatchResult;
use Flo\Tournoi\Domain\Match\ValueObjects\Set;
use Flo\Tournoi\Domain\Match\ValueObjects\SetCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MatchController extends Controller
{
    private
        $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function enterMatchResultAction(string $uuid): Response
    {
        $setCollection = new SetCollection();        

        $setCollection->add(new Set(11, 7));
        $setCollection->add(new Set(11, 9));
        $setCollection->add(new Set(12, 10));

        $match = $this->matchRepository->findById(new Uuid($uuid));
        $match->setResult(
            new MatchResult($match->player1(), $match->player2(), $setCollection)
        );
        $this->matchRepository->update($match);

        return $this->redirectToRoute('tournoi_group_detail', ['uuid' => $match->groupUuid()]);
    }
}
