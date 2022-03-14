<?php

namespace app\entities;

use easy\db\ORM\Entity;

class GuestbookEntry extends Entity
{
    public ?int $id;
    public string $author;
    public string $title;
    public string $text;
    public \DateTime $created_at;
    public ?\DateTime $deleted_at = null;
    public GuestbookEntryStatus $status;
    public ?int $user_id;
    public int $author_id;
}
