<?php

declare (strict_types = 1);

namespace App\Application\Actions\Chat;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface
{
    public function onOpen(ConnectionInterface $conn)
    {
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }
}