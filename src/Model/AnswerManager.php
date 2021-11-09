<?php

namespace App\Model;

class AnswerManager extends AbstractManager
{
    public const TABLE = 'answer';

    public function insert(array $answerData): int
    {
        $query = '
        INSERT INTO answer (description, created_at, user_id, ranking, question_id)
        VALUES (:description, NOW(), :userId, 0, :questionId)
        ';
        $statement = $this->pdo->prepare($query);

        $statement->bindValue('description', $answerData['description'], \PDO::PARAM_STR);
        $statement->bindValue('userId', $answerData['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('questionId', $answerData['question_id'], \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $answers): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . "SET 'description' = :description WHERE id=:id");
        $statement->bindValue('id', $answers['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
