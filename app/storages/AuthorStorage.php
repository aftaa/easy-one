<?php

namespace app\storages;

use app\entities\Author;
use app\entities\GuestbookEntry;
use easy\db\ORM\Entity;
use easy\db\Storage;

class AuthorStorage extends Storage
{
    /**
     * @return Author[]
     * @throws \Exception
     */
    public function selectAuthors(): array
    {
        return $this->createQueryBuilder()
            ->orderBy(['name', SORT_ASC])
            ->getQuery()
            ->getResults()
            ->asEntities();
    }

    /**
     * @param string $author
     * @return Entity|null
     */
    public function selectByName(string $author): ?Entity
    {
        return $this->createQueryBuilder()
            ->where('name = :author')
            ->param(':author', $author)
            ->getQuery()
            ->getResult()?->asEntity();
    }
}
