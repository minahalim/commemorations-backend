<?php

declare (strict_types = 1);

namespace App\Application\Actions\Question;

use App\Domain\Question\Question;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateQuestionAction extends QuestionAction
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
        $question->sender = (string) $data['sender'];
        $question->question = (string) $data['question'];
        $question->status = (string) $data['status'];

        $rowsAffected = $this->questionRepository->updateQuestion($question);

        $this->logger->info("Question of id $id was updated.");

        return $this->respondWithData($rowsAffected);
    }
}