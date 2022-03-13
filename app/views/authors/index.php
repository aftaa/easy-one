<?php
/** @var $authors \app\entities\Author[] */
/** @var $this \easy\MVC\View */
?>

<table class="table">
    <thead>
    <tr>
        <th></th>
        <th>name:</th>
        <th>numbers of books:</th>
        <th>look the books:</th>
    </tr>
    </thead>
    <?php foreach ($authors as $author): ?>
    <tr>
        <td>
            <?= $author->id ?>
        </td>
        <td>
            <?= $author->name ?>
        </td>
        <td>

        </td>
        <td>

        </td>
    </tr>
    <?php endforeach ?>
</table>
