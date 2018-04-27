<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Player;

use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Player\Repositories\Mysql as PlayerRepository;
use Flo\Tournoi\Domain\Core\ValueObjects\Uuid;

class ListPlayerController extends Controller
{
    private
        $playerRepository;

    public function __construct(PlayerRepository $repository)
    {
        $this->playerRepository = $repository;
    }

    public function displayListAction()
    {
        $players = $this->playerRepository->findAll();

        return $this->render('Player/listPlayer.html.twig', array('players' => $players));
    }
}
