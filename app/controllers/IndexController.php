<?php

namespace app\controllers;

use app\services\sub\SubService1;
use app\storages\GuestbookEntryStorage;
use easy\Application;
use easy\basic\router\Route;
use app\services\TestService1;
use easy\db\Connection;
use easy\helpers\QueryTimes;
use easy\http\Request;
use easy\MVC\Controller;

#[Route('/')]
class IndexController extends Controller
{
    #[Route('', name: 'site_index')]
    public function index()
    {
        $this->render('index/site', []);
    }
    /**
     * @throws \Throwable
     */
    #[Route('test1', name: 'entry_index')]
    public function function1(GuestbookEntryStorage $storage, Request $request)
    {
        $page = $request->query('page') ?? 1;
        $all = $storage->selectPage($page);
        $count = $storage->selectCount();
        $this->render('index/index', [
            'all' => $all,
            'count' => $count,
            'page' => $page,
            'limit' => 10,
        ]);
    }

    /**
     * @throws \Throwable
     */
    #[Route('deleted', name: 'entry_deleted')]
    public function deleted(Request $request, GuestbookEntryStorage $storage)
    {
        $page = $request->query('page') ?? 1;
        $entries = $storage->getDeletedEntries($page);
        $count = $storage->deletedCount();
        $this->render('index/deleted', [
            'entries' => $entries,
            'count' => $count,
            'page' => $page,
            'limit' => 10,
        ]);
    }
    /**
     * @throws \Exception
     */
    #[Route('modify', name: 'entry_modify')]
    public function modify(GuestbookEntryStorage $storage, Request $request)
    {
        $entry = $storage->load($request->request('id'))->asEntity();

        if ($request->isPost()) {
            $entry->author = $request->post('author');
            $entry->title = $request->post('title');
            $entry->text = $request->post('text');
            $storage->store($entry);
        }

        $this->render('index/modify', [
            'entry' => $entry,
        ]);
    }
}
