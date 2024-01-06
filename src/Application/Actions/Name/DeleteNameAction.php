<?php

declare (strict_types = 1);

namespace App\Application\Actions\Name;

use App\Domain\Name\Name;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteNameAction extends NameAction
{

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->getFormData();

        $id = (int) $data['id'];

        $name = new Name();
        $name->id = $id;

        $rowsAffected = $this->nameRepository->deleteName($name);

        $this->logger->info("Name of id `${id}` was deleted.");

        return $this->respondWithData($rowsAffected);
    }
}