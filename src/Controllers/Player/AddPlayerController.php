<?php

declare(strict_types = 1);

namespace Flo\Tournoi\Controllers\Player;

use Flo\Tournoi\Domain\Player\Collections\PlayerCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Flo\Tournoi\Domain\Player\Entities\Player;
use Flo\Tournoi\Persistence\Player\Repositories\Memory as UserRepository;

class AddPlayerController extends Controller
{
    public function formAddAction()
    {
        echo "formAddAction";

        return $this->render('Player/addPlayer.html.twig');
    }

    public function submitAddAction(Request $request): Response
    {
        echo "submitAddAction ";

        $name = $request->request->get('name');

        $player = new Player("1", $name);

        $memory = new UserRepository();

        $memory->persist($player);

        echo "<pre>";
        var_dump($memory->collection);
        echo "</pre>";

        return $this->render('Player/addPlayer.html.twig');
    }
}
