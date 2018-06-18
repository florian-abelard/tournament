<?php
namespace Flo\Tournoi\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function index()
    {
        return $this->render('home.html.twig');
    }
}
