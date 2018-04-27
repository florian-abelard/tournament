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

class AddPlayerController extends Controller
{
    private
        $playerRepository;

    public function __construct(PlayerRepository $repository)
    {
        $this->playerRepository = $repository;
    }

    public function formAddAction()
    {
        return $this->render('Player/addPlayer.html.twig');
    }

    public function submitAddAction(Request $request): Response
    {
        $name = $request->request->get('name');

        $player = new Player(
            new Uuid(),
            $name
        );

        $this->playerRepository->persist($player);

        return $this->render('Player/addPlayer.html.twig');
    }
}
