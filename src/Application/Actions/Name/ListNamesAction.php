<?php

declare (strict_types = 1);

namespace App\Application\Actions\Name;

use Psr\Http\Message\ResponseInterface as Response;

class ListNamesAction extends NameAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $names = $this->nameRepository->findAll();

        $this->logger->info("Names list was viewed.");

        return $this->respondWithData($names);
    }
}