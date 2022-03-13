<?php

namespace app\entities;

use easy\db\ORM\Entity;

class Author extends Entity
{
    public ?int $id = null;
    public string $name = '';
    //TODO ooopse
    public ?int $booksCount = 0;
}
