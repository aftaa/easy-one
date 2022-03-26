<?php
/** @var $this \easy\MVC\View */
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Hi!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $this->href('site_index') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->href('authors_index') ?>">Authors</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Entries
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= $this->href('entry_create') ?>">Create</a></li>
                        <li><?= $this->link('entry_index', [], 'List', ['class' => 'dropdown-item']) ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><?= $this->link('entry_deleted', [], 'Deleted', ['class' => 'dropdown-item', 'style' => 'color: red;']) ?></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <?= $this->link('show_tables', params: [], label: 'Show Tables', htmlOptions: ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" tabindex="-1" aria-disabled="true" href="<?= $this->href('test_author') ?>">Author test</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>