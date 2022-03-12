<?php

namespace app\storages;

use easy\db\DBAL\QueryBuilder;
use easy\db\Storage;

class GuestbookEntryStorage extends Storage
{
    /**
     * @param int $limit
     * @return \easy\db\ORM\Entity[]
     * @throws \Exception
     */
    public function selectPage(int $page): array
    {
        return $this->createQueryBuilder()
            ->limit(10)
            ->offset(((int)$page - 1) * 20)
            ->getQuery()
            ->getResults()
            ->asEntities();
    }
}
