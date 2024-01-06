<?php

declare (strict_types = 1);

namespace App\Application\Actions\Question;

use App\Domain\Question\Question;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteQuestionAction extends QuestionAction
{

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->getFormData();

        $id = (int) $data['id'];

        $question = new Question();
        $question->id = $id;

        $rowsAffected = $this->questionRepository->deleteQuestion($question);

        $this->logger->info("Question of id `${id}` was deleted.");

        return $this->respondWithData($rowsAffected);
    }
}