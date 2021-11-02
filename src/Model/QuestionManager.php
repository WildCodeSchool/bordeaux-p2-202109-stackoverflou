<?php

namespace App\Model;

class QuestionManager extends AbstractManager
{
    public const TABLE = 'question';
    public function insert(array $question): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(`title`,`description`) VALUES (:title,:description)");
        $statement->bindValue('title', $question['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $question['description'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $question): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $question['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $question['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
