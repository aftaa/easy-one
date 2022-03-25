<?php
/** @var $authors \app\entities\Author[] */
/** @var $this \easy\MVC\View */
/** @var $entriesNumber array */
?>

<table class="table">
    <thead>
    <tr>
        <th></th>
        <th>name:</th>
        <th>numbers of entries:</th>
        <th>look the entries:</th>
    </tr>
    </thead>
    <?php foreach ($authors as $id => $author): ?>
    <tr>
        <td>
            <?= $author->id ?>
        </td>
        <td>
            <?= $author->name ?>
        </td>
        <td>
            <?= @$entriesNumber[$id]['count'] ?>
        </td>
        <td>
            <?= $this->link('entry_index', ['authorId' => $author->id], 'look!') ?>
        </td>
    </tr>
    <?php endforeach ?>
</table>
