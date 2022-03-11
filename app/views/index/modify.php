<?php

/** @var $entry \app\entities\GuestbookEntry */
/** @var $this \easy\MVC\View */
$this->params['title'] = 'modify-test';
?>
<h1>ID #<?= $entry->id ?></h1>
<a href="<?= $this->link('entry_index') ?>">back to the table</a>
<form method="post">
    <input type="hidden" name="id" value="<?= $entry->id ?>">
    <table>
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
    </table>
    <input type="submit" name="store" value="store">
</form>