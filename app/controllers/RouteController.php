<?php

namespace app\controllers;

use easy\basic\router\Route;
use easy\mvc\Controller;

class RouteController extends Controller
{
    #[Route('/{lang}/route/test/prefix{id<[0-9]+>}/test/{word}', name: 'test_route_with_param', methods: ['GET'])]
    public function testAction()
    {
    }
}
