<?php

namespace app\controllers;

use app\services\sub\SubService1;
use app\storages\GuestbookEntryStorage;
use easy\Application;
use easy\basic\router\Route;
use app\services\TestService1;
use easy\db\Connection;
use easy\helpers\QueryTimes;

#[Route('/')]
class IndexController
{
    public function __construct()
    {

    }

    #[Route('test1')]
    public function function1(GuestbookEntryStorage $storage)
    {
        $res = $storage->selectFirst();
        ?>
        <table border="1">
            <tr>
                <td>author</td>
            </tr>
            <?php foreach ($res as $row): ?>
                <tr>
                    <td><?= $row->author ?></td>
                    <td><?= $row->status->value ?></td>

                </tr>
            <?php endforeach ?>
        </table>
        <?php
    }

    #[Route('test2')]
    public function test2()
    {

    }
}
