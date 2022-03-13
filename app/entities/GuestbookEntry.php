<?php

namespace app\entities;

use easy\db\ORM\Entity;

class GuestbookEntry extends Entity
{
    public ?int $id;
    public string $author;
    public string $title;
    public string $text;
    public ?\DateTimeImmutable $created_at = null;
    public ?\DateTimeImmutable $deleted_at = null;
    public GuestbookEntryStatus $status;
    public ?int $user_id;
    #[ManyToOne('User', column: 'user_id')]
    public User $user;
}
