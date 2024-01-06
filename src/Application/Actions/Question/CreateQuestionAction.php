<?php

declare (strict_types = 1);

namespace App\Application\Actions\Question;

use App\Domain\Question\Question;
use Psr\Http\Message\ResponseInterface as Response;

class CreateQuestionAction extends QuestionAction
{

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->getFormData();

        $question = new Question();
        $question->sender = (string) $data['sender'];
        $question->question = (string) $data['question'];
        $question->status = (string) $data['status'];

        $createdQuestionID = $this->questionRepository->createQuestion($question);

        $this->logger->info("Question of id $createdQuestionID was created.");

        return $this->respondWithData($createdQuestionID);
    }
}