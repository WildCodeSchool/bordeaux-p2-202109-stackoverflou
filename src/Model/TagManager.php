<?php

namespace App\Model;

class TagManager extends AbstractManager
{
    public const TABLE = 'tag';
    public function insert(array $tags): int
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(`name`) 
        VALUES (:name)");
        $statement->bindValue(':name', $tags['name'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $tags): bool
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name WHERE id=:id");
        $statement->bindValue(':id', $tags['id'], \PDO::PARAM_INT);
        $statement->bindValue(':name', $tags['name'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function selectTagsByQuestionId(int $questionId): array
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->prepare("
        SELECT t.id, t.name FROM tag t
        JOIN tag_has_question thq ON thq.tag_id = t.id
        JOIN question q ON thq.question_id = q.id
        WHERE q.id = :questionId
        ");
        $statement->bindValue(':questionId', $questionId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function bindTagWithQuestion($tagId, $questionId)
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->prepare('
        INSERT INTO tag_has_question 
        (tag_id, question_id)
        VALUES (:tagId, :questionId)');
        $statement->bindValue(':tagId', $tagId, \PDO::PARAM_INT);
        $statement->bindValue(':questionId', $questionId, \PDO::PARAM_INT);
        $statement->execute();
    }
}
