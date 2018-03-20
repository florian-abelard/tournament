<?php
namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public function index()
    {
        return new Response(
            '<html><body>Test simple page</body></html>'
        );
    }
}
