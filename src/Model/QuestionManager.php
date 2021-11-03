<?php

namespace App\Model;

class QuestionManager extends AbstractManager
{
    public const TABLE = 'question';


    public function insert(array $question): int
    {
        $sta = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(`title`,`description`,`created_at`) 
        VALUES (:t,:description, NOW())");

        $sta->bindValue('t', $question['title'], \PDO::PARAM_STR);
        $sta->bindValue('description', $question['description'], \PDO::PARAM_STR);
        $sta->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $question): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $question['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $question['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
    public function selectOneByIdTag(int $id)
    {
        $statement = $this->pdo->prepare("SELECT question.id, question.title, question.description, 
        tag.id, tag.name FROM " . 'question' . "
        JOIN tag_has_question tq 
        ON question.id = tq.question_id
        JOIN tag 
        ON tag.id = tq.tag_id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
