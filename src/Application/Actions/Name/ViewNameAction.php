<?php

declare (strict_types = 1);

namespace App\Application\Actions\Name;

use Psr\Http\Message\ResponseInterface as Response;

class ViewNameAction extends NameAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $nameId = (int) $this->resolveArg('id');
        $name = $this->nameRepository->findNameOfId($nameId);

        $this->logger->info("Name of id $nameId was viewed.");

        return $this->respondWithData($name);
    }
}