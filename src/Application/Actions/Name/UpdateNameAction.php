<?php

declare (strict_types = 1);

namespace App\Application\Actions\Name;

use App\Domain\Name\Name;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateNameAction extends NameAction
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
        $name->name = (string) $data['name'];
        $name->category = (string) $data['category'];
        $name->liturgy = (string) $data['liturgy'];

        $rowsAffected = $this->nameRepository->updateName($name);

        $this->logger->info("Name of id $id was updated.");

        return $this->respondWithData($rowsAffected);
    }
}
