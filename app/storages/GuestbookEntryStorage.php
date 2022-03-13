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
            ->where('deleted_at IS NULL')
            ->limit(10)
            ->offset(((int)$page - 1) * 10)
            ->getQuery()
            ->getResults()
            ->asEntities();
    }

    /**
     * @return int
     */
    public function selectCount(): int
    {
        return $this->createQueryBuilder()
            ->select('COUNT(*) AS count')
            ->where('deleted_at IS NULL')
            ->getQuery()
            ->getResult()
            ->asArray()['count'];
    }

    /**
     * @return int
     */
    public function deletedCount(): int
    {
        return $this->createQueryBuilder()
            ->select('COUNT(*) AS count')
            ->where('deleted_at IS NOT NULL')
            ->getQuery()
            ->getResult()
            ->asArray()['count'];
    }

    /**
     * @param mixed $page
     * @return \easy\db\ORM\Entity[]
     * @throws \Exception
     */
    public function getDeletedEntries(mixed $page): array
    {
        return $this->createQueryBuilder()
            ->where('deleted_at IS NOT NULL')
            ->orderBy(['deleted_at', SORT_DESC])
            ->limit(10)
            ->offset(((int)$page - 1) * 10)
            ->getQuery()
            ->getResults()
            ->asEntities();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        return $this->createUpgradeBuilder()
            ->set('deleted_at = NULL')
            ->where('id = :id')
            ->param(':id', $id)
            ->getQuery()
            ->getResult();
    }
}
