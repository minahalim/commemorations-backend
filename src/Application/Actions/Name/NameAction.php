<?php

declare (strict_types = 1);

namespace App\Application\Actions\Name;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Name\NameRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpNotFoundException;

abstract class NameAction extends Action
{
    protected NameRepository $nameRepository;

    protected Request $request;

    protected Response $response;

    public function __construct(LoggerInterface $logger, NameRepository $nameRepository)
    {
        parent::__construct($logger);
        $this->nameRepository = $nameRepository;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @return array|object
     */
    protected function getFormData()
    {
        return $this->request->getParsedBody();
    }
}