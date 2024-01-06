<?php

declare (strict_types = 1);

namespace App\Application\Actions\Question;

use App\Application\Actions\Action;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\Question\QuestionRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpNotFoundException;

abstract class QuestionAction extends Action
{
    protected QuestionRepository $questionRepository;

    protected Request $request;

    protected Response $response;

    public function __construct(LoggerInterface $logger, QuestionRepository $questionRepository)
    {
        parent::__construct($logger);
        $this->questionRepository = $questionRepository;
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