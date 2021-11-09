<?php

namespace App\Model;

class AnswerManager extends AbstractManager
{
    public const TABLE = 'answer';

    public function insert(array $answers): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            "(`description`,`created_at`, user_id, ranking, question_id) 
        VALUES (:description, NOW(), :user_id, :ranking, :question_id)");

        $statement->bindValue('description', $answers['description'], \PDO::PARAM_STR);
        $statement->bindValue('user_id', $answers['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('question_id', $answers['question_id'], \PDO::PARAM_INT);
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
