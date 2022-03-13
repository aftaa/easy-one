<?php

/** @var $entry \app\entities\GuestbookEntry */
/** @var $this \easy\MVC\View */
/** @var $statusCases GuestbookEntryStatus */

use app\entities\GuestbookEntryStatus;

$this->params['title'] = 'modify-test';
?>
<h1>ID #<?= $entry->id ?></h1>
<form method="post">
    <input type="hidden" name="id" value="<?= $entry->id ?>">
    <table class="table">
        <tr>
            <td>Author:</td>
            <td><input type="text" name="author" value="<?= $this->escape($entry->author) ?>"></td>
        </tr>
        <tr>
            <td>Title:</td>
            <td><input type="text" name="title" value="<?= $this->escape($entry->title) ?>"></td>
        </tr>
        <tr>
            <td>Text:</td>
            <td><input type="text" name="text" value="<?= $this->escape($entry->text) ?>"></td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>
                <select name="status">
                    <?php foreach ($statusCases::cases() as $statusCase): ?>
                    <option value="<?= $statusCase->value ?>"<?php
                        if ($statusCase == $entry->status) echo ' selected="1"'
                    ?>><?= $statusCase->name ?></option>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Created at</td>
            <td>
                <label>
                    <input class="class-form" type="date" name="created_at" value="<?= $entry->created_at->format('Y-m-d H:i:s') ?>" required>
                </label>
            </td>
        </tr>
        <tr>
            <td>Deleted at</td>
            <td>
                <label>
                    <input class="class-form" type="date" name="deleted_at" value="<?= $entry->created_at->format('Y-m-d H:i:s') ?>">
                </label>
            </td>
        </tr>
    </table>
    <input type="submit" name="store" value="store">
</form>