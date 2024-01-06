<?php

declare (strict_types = 1);

namespace App\Domain\Question;

class Question
{
    public int $id;

    public string $sender;

    public string $question;

    public string $status;

    public int $deleted;

    public string $created_at;

    public string $updated_at;
}