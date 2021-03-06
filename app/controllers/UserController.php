<?php

namespace app\controllers;

use app\storages\GroupStorage;
use app\storages\UserStorage;
use easy\basic\router\Route;
use easy\http\Request;
use easy\mvc\Controller;

#[Route('/users')]
class UserController extends Controller
{
    /**
     * @throws \Exception
     */
    #[Route('/list', name: 'user_list', methods: ['GET'])]
    public function list(UserStorage $userStorage, GroupStorage $groupStorage)
    {
        if ('admin' != $this->user()?->group->name) {
            header('HTTP/1.0 403 Forbidden');
            echo '403 Forbidden';
            die;
        }

        $groups = $groupStorage->select()->asPairs('name');
        $users = $userStorage->select()->asEntities();
        $this->render('users/list', [
            'users' => $users,
            'groups' => $groups,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/update', name: 'update_users', methods: ['POST'])]
    public function update(Request $request, UserStorage $userStorage)
    {
        $users = $request->post('users');
        foreach ($users as $id => $user) {
            $userStorage->updateUser($id, $user['group_id'], $user['is_verified']);
        }

        $this->redirectToRoute('user_list');
    }

    #[Route('/add', name: 'add_user')]
    public function add(Request $request, UserStorage $storage)
    {
        if ('admin' !== $this->user()?->group->name) {
            $this->render('errors/404');
        } else {
            $this->render('users/add');
        }
    }
}
