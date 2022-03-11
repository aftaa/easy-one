<?php

/** @var $this \easy\MVC\Layout */

?><!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $title ?? 'Homepage' ?></title>
</head>
<body>
<div id="content"><?= $this->content ?></div>
<?php require_once 'app/views/debug/bottom.php' ?>
</body>
</html>