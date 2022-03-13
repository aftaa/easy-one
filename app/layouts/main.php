<?php

/** @var $this \easy\MVC\Layout */

?><!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $title ?? 'Homepage' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"></head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<body>

<div id="content" style="padding: 0 100px;">
    <h1><a href="<?= $this->link('site_index') ?>">Hi</a>,</h1>
    <h2><a href="<?= $this->link('entry_index') ?>">entries</a>
    <a href="<?= $this->link('entry_deleted') ?>">deleted</a></>
    <a href="<?= $this->link('entry_create') ?>">create</a></>
    <a href="<?= $this->link('authors_index') ?>">authors</a></>
    <?= $this->content ?></div>
<?php require_once 'app/views/debug/bottom.php' ?>
</body>
</html>