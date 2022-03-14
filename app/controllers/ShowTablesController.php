<?php

namespace app\controllers;

use app\storages\AuthorStorage;
use easy\basic\router\Route;

class ShowTablesController extends \easy\MVC\Controller
{
    /**
     * @throws \Throwable
     */
    #[Route('/show_tables', name: 'show_tables')]
    public function showTables(AuthorStorage $storage)
    {
        $tables = $storage->showTables();
        $this->render('show/tables', [
            'tables' => $tables,
        ]);
    }
}