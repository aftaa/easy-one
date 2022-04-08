<?php

namespace app\controllers\docs;

use easy\basic\router\Route;
use easy\MVC\Controller;

class IndexController extends Controller
{
    #[Route('/docs/', name: 'docs_index')]
    public function index()
    {
        $this->render('docs/index');
    }
}
