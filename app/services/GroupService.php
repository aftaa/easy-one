<?php

namespace app\services;

use app\storages\GroupStorage;
use app\storages\UserStorage;
use easy\db\Transaction;

class GroupService
{
    public function __construct(
        private GroupStorage $groupStorage,
        private UserStorage  $userStorage,
        private Transaction  $transaction,
    )
    {
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteGroups(array $ids)
    {
        foreach ($ids as $groupId) {

            try {
                $this->transaction->begin();
                $this->groupStorage->delete($groupId);
                $this->userStorage->groupSetNull($groupId);
                $this->transaction->commit();
            } catch (\Exception $e) {
                $this->transaction->rollback();
            }
        }
    }
}
