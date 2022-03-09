<?php

namespace app\storages;

use easy\db\DBAL\QueryBuilder;
use easy\db\Storage;

class GuestbookEntryStorage extends Storage
{
    /**
     * @throws \Exception
     */
    public function selectFirst($limit = 20)
    {
        $res = $this->createQueryBuilder()->limit($limit)->getQuery()->getResults()->asEntities();
        return $res;
    }
}