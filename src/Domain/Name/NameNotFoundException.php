<?php

declare (strict_types = 1);

namespace App\Domain\Name;

use App\Domain\DomainException\DomainRecordNotFoundException;

class NameNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The name you requested does not exist.';
}
