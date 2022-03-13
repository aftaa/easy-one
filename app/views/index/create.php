<?php

/** @var $this \easy\MVC\View */
/** @var $cases array */

?>
<form method="post" action="<?= $this->link('entry_create') ?>">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="author" class="col-form-label">Author: </label>
        </div>
        <div class="col-auto">
            <input type="text" name="author" id="author" class="form-control" required>
        </div>
    </div>
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="title" class="col-form-label">Title: </label>
        </div>
        <div class="col-auto">
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
    </div>
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="text" class="col-form-label">Text: </label>
        </div>
        <div class="col-auto">
            <input type="text" name="text" id="text" class="form-control" required>
        </div>
    </div>
    <input type="submit" name="create" value="create">
</form>