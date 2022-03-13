<?php

namespace app\controllers;

use app\entities\Author;
use app\storages\AuthorStorage;
use app\storages\GuestbookEntryStorage;
use easy\basic\router\Route;
use easy\MVC\Controller;

#[Route('/authors')]
class AuthorController extends Controller
{
    /**
     * @throws \ReflectionException
     * @throws \Throwable
     */
    #[Route('', name: 'authors_index')]
    public function index(AuthorStorage $authorStorage)
    {
        $authors = $authorStorage->selectAuthors();

        $entriesNumber = $authorStorage->selectEntriesNumber($authors);

        $this->render('authors/index', [
            'authors' => $authors,
        ]);
    }
}