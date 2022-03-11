<?php

/** @var $all \app\entities\GuestbookEntry[] */
/** @var $this \easy\MVC\View */

?>

<table border="1">
    <tr>
        <td>ID</td>
        <td>author</td>
        <td>title</td>
        <td>text</td>
    </tr>
    <?php foreach ($all as $row): ?>
        <tr>
            <td><?= $row->id ?></td>
            <td><?= $row->author ?></td>
            <td><a href="<?= $this->link('entry_modify', ['id' => $row->id]) ?>"><?= $row->title ?></a></td>
            <td><?= $row->text ?></td>
        </tr>
    <?php endforeach ?>
</table>