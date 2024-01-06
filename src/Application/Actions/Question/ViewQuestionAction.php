<?php

declare (strict_types = 1);

namespace App\Application\Actions\Question;

use Psr\Http\Message\ResponseInterface as Response;

class ViewQuestionAction extends QuestionAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $questionId = (int) $this->resolveArg('id');
        $question = $this->questionRepository->findQuestionOfId($questionId);

        $this->logger->info("Question of id $questionId was viewed.");

        return $this->respondWithData($question);
    }
}