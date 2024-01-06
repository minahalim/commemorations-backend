<?php

declare (strict_types = 1);

namespace App\Application\Actions\Question;

use Psr\Http\Message\ResponseInterface as Response;

class ListQuestionsAction extends QuestionAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $questions = $this->questionRepository->findAll();

        $this->logger->info("Questions list was viewed.");

        return $this->respondWithData($questions);
    }
}