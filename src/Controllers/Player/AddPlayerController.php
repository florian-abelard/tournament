<?php
namespace Flo\Tournoi\Controllers\Player;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AddPlayerController extends Controller
{
    public function formAddAction()
    {
        echo "formAddAction";

        return $this->render('Player/addPlayer.html.twig');
    }

    public function submitAddAction(): Response
    {
        echo "submitAddAction";


        return $this->render('Player/addPlayer.html.twig');
    }
}
