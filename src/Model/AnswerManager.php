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

    public function getAnswersByQuestionId(int $questionId): array
    {
        $query = ('
        SELECT a.*, u.username, u.pseudo_github FROM answer a 
        JOIN user u 
        ON a.user_id = u.id
        WHERE a.question_id=:questionId
        ');
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':questionId', $questionId);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function nbAnswersByUser()
    {
        $statement = $this->pdo->prepare("
        SELECT count(answer.user_id) as nbAnswer, u.username FROM answer
        JOIN user u
        ON answer.user_id = u.id
        group by u.id");
        return $statement->fetchAll();
    }

    public function rankUp($answerId): void
    {
        $statement = $this->pdo->prepare("UPDATE answer 
        SET ranking = ranking +1
        WHERE id=:id");
        $statement->bindValue(":id", $answerId);
        $statement->execute();
    }

    public function nbRankByAnswers(int $questionId)
    {
        $query = (" SELECT id, ranking FROM answer a 
        WHERE id=:id;");
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetch();
    }
}
