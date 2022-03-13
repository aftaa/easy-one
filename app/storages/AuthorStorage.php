<?php

namespace app\storages;

use app\entities\Author;
use app\entities\GuestbookEntry;
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
     * @param Author[] $authors
     * @return void
     */
    public function selectEntriesNumber(array $authors)
    {
        foreach ($authors as $authorId => $author) {
        }
    }
}