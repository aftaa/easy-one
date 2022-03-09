<?php

namespace app\controllers\admin;

use easy\basic\router\Route;

#[Route('/admin')]
class IndexController
{
    #[Route('/admin1', name: 'admin1')]
    public function test1()
    {

    }

    #[Route('/admin2', name: 'admin2')]
    public function test2()
    {

    }
}
