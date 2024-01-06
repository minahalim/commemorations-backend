<?php

declare (strict_types = 1);

namespace App\Application\Actions\Name;

use App\Domain\Name\Name;
use Psr\Http\Message\ResponseInterface as Response;

class CreateNameAction extends NameAction
{

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->getFormData();

        $name = new Name();
        $name->name = (string) $data['name'];
        $name->category = (string) $data['category'];
        $name->liturgy = (string) $data['liturgy'];

        $createdNameID = $this->nameRepository->createName($name);

        $this->logger->info("Name of id $createdNameID was created.");

        return $this->respondWithData($createdNameID);
    }
}
