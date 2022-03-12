<?php

/** @var $all \app\entities\GuestbookEntry[] */
/** @var $this \easy\MVC\View */

?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">author</th>
        <th scope="col">title</th>
        <th scope="col">text</th>
    </tr>
    </thead>
    <?php foreach ($all as $row): ?>
        <tr>
            <td><?= $row->id ?></td>
            <td><?= $row->author ?></td>
            <td><a href="<?= $this->link('entry_modify', ['id' => $row->id]) ?>"><?= $row->title ?></a></td>
            <td><?= $row->text ?></td>
        </tr>
    <?php endforeach ?>
</table>