<?php

namespace app\controllers;

use app\entities\GuestbookEntry;
use app\entities\GuestbookEntryStatus;
use app\storages\GuestbookEntryStorage;
use easy\basic\router\Route;
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
        if ($request->isPost() && ($deleted = $request->query('delete'))) {
            foreach ($deleted as $id) {
                $storage->softDelete($id);
            }
        }
        $authorId = $request->query('authorId');
        $page = $request->query('page') ?? 1;
        $all = $storage->selectPage($page, $authorId);
        $count = $storage->selectCount($authorId);
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
        if ($request->isPost() && ($deleted = $request->query('delete'))) {
            foreach ($deleted as $id) {
                $storage->restore($id);
            }
        }

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
//        $statusCases = GuestbookEntryStatus::c();
        $entry = $storage->load($request->query('id'))->asEntity();

        if ($request->isPost()) {
            $entry->author = $request->post('author');
            $entry->title = $request->post('title');
            $entry->text = $request->post('text');
            $entry->status = GuestbookEntryStatus::from($request->post('status'));
            $storage->store($entry);
        }

        $this->render('index/modify', [
            'entry' => $entry,
            'statusCases' => GuestbookEntryStatus::class,
        ]);
    }

    /**
     * @throws \ReflectionException
     * @throws \Throwable
     */
    #[Route('create', name: 'entry_create')]
    public function create(Request $request, GuestbookEntryStorage $storage)
    {
        if ($request->isPost()) {
            $entry = new GuestbookEntry();
            $entry->author = $request->post('author');
            $entry->title = $request->post('title');
            $entry->text = $request->post('text');
            $entry->created_at = (new \DateTime('now'))->setTimezone(new \DateTimeZone('Europe/Moscow'));
            $entry->status = GuestbookEntryStatus::VERIFIED;
            $storage->store($entry);
        }

        $this->render('index/create', [
            'statusCases' => GuestbookEntryStatus::cases(),
        ]);
    }
}
