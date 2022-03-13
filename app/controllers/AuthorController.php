<?php

namespace app\controllers;

use app\entities\Author;
use app\storages\AuthorStorage;
use app\storages\GuestbookEntryStorage;
use easy\basic\router\Route;
use easy\db\Connection;
use easy\MVC\Controller;

#[Route('/authors')]
class AuthorController extends Controller
{
    /**
     * @throws \ReflectionException
     * @throws \Throwable
     */
    #[Route('', name: 'authors_index')]
    public function index(AuthorStorage $authorStorage, GuestbookEntryStorage $entryStorage, Connection $connection)
    {
        $authors = $authorStorage->selectAuthors();
        $entriesNumber = $entryStorage->entriesNumberByAuthorId();
//        echo '<pre>';
//        print_r($entriesNumber);die;

        $this->render('authors/index', [
            'authors' => $authors,
            'entriesNumber' => $entriesNumber,
        ]);
    }
}