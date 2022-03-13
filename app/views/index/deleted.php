<?php

/** @var $entries \app\entities\GuestbookEntry[] */
/** @var $this \easy\MVC\View */
/** @var $count int */
/** @var $page int */
/** @var $limit int */

?>
<h2>Total count: <?= $count ?></h2>
<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">author</th>
        <th scope="col">title</th>
        <th scope="col">text</th>
        <th scope="col">created_at</th>
        <th scope="col">deleted_at</th>
        <th scope="col">status</th>
        <th scope="col">user_id</th>
    </tr>
    </thead>
    <?php foreach ($entries as $row): ?>
        <tr>
            <td><?= $row->id ?></td>
            <td><?= $row->author ?></td>
            <td><a href="<?= $this->link('entry_modify', ['id' => $row->id]) ?>"><?= $row->title ?></a></td>
            <td><?= $row->text ?></td>
            <td><?= $row->created_at->format('d.m.Y H:i') ?></td>
            <td><?= $row->deleted_at?->format('d.m.Y H:i') ?></td>
            <td><?= $row->status->value ?></td>
            <td><?= $row->user_id ?></td>
        </tr>
    <?php endforeach ?>
</table>

<?php for ($i = 1; $i <= ceil($count / $limit); $i++): ?>
    <?php if ($page == $i): ?><b><?php endif ?>
    <a href="<?= $this->link('entry_deleted', ['page' => $i]) ?>"><?= $i ?></a>
    <?php if ($page == $i): ?></b><?php endif ?>

<?php endfor ?>