<?php

declare (strict_types = 1);

namespace App\Domain\Question;

use PDO;

class QuestionRepository
{
    /**
     * @var Question[]
     */
    private array $questions;

    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * @param Question[]|null $questions
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;

        $sth = $this->connection->prepare("
            SELECT
                id,
                sender,
                question,
                status,
                deleted
            FROM questions
        ");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_CLASS);

        $this->questions = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->questions);
    }

    /**
     * {@inheritdoc}
     */
    public function findQuestionOfId(int $id): Question
    {
        $sth = $this->connection->prepare("SELECT * FROM questions where id=$id");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_CLASS, Question::class);

        if (!isset($data[0])) {
            throw new QuestionNotFoundException();
        }

        return $data[0];
    }

    /**
     * {@inheritdoc}
     */
    public function createQuestion(Question $question): string
    {
        $sth = $this->connection->prepare("
            Insert into questions(
                sender,
                question,
                status
            ) values(
                :sender,
                :question,
                :status
            )
        ");

        $sth->execute([
            'sender' => $question->sender,
            'question' => $question->question,
            'status' => $question->status,
        ]);

        return $this->connection->lastInsertId();
    }

    public function updateQuestion(Question $question): int
    {
        $sth = $this->connection->prepare("
            update questions
                set
                sender=:sender,
                question=:question,
                status=:status
            where id=:id
        ");

        $sth->execute([
            'sender' => $question->sender,
            'question' => $question->question,
            'status' => $question->status,
            'id' => $question->id,
        ]);

        return $sth->rowCount();
    }

    public function deleteQuestion(Question $question): int
    {
        $sth = $this->connection->prepare("update questions set deleted=1 where id=:id");

        $sth->execute([":id" => $question->id]);

        return $sth->rowCount();
    }
}