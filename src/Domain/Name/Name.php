<?php

declare (strict_types = 1);

namespace App\Domain\Name;

class Name
{
    public int $id;

    public string $name;

    public string $category;

    public string $liturgy;

    public int $deleted;

    public string $created_at;

    public string $updated_at;
}
