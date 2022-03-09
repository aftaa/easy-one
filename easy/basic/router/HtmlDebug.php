<?php

namespace easy\basic\router;

use easy\basic\Router;

class HtmlDebug extends Router
{
    public function debug()
    {
        /** @var $byPath Routing[] */
        $byPath = $this->byPath;
        ?>
        <h3>Actual: <b><?= $this->actual ?? 'NULL' ?></b></h3>
        <table border="1">
            <thead>
            <tr>
                <th>Name</th>
                <th>Path</th>
                <th>Controller</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($byPath as $path => $routing): ?>
                <tr>
                    <td><?= $routing->name ?></td>
                    <td><?= $routing->path ?></td>
                    <td><?= $routing->controller ?></td>
                    <td><?= $routing->action ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

        <?php
    }
}
