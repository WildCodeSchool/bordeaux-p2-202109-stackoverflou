<?php

namespace App\Model;

class QuestionManager extends AbstractManager
{
    public const TABLE = 'question';


    public function insert(array $question): int
    {
        $sta = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(`title`,`description`,`created_at`, user_id) 
        VALUES (:t,:description, NOW(), :user_id)");

        $sta->bindValue('t', $question['title'], \PDO::PARAM_STR);
        $sta->bindValue('description', $question['description'], \PDO::PARAM_STR);
        $sta->bindValue('user_id', $question['user_id'], \PDO::PARAM_INT);
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
    public function selectQuestionsByTag(int $id)
    {
        $statement = $this->pdo->prepare("
        SELECT q.id, q.title, q.description FROM question q
        JOIN tag_has_question thq
        ON thq.question_id = q.id
        JOIN tag t
        ON t.id = thq.tag_id
        WHERE t.id = :id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
    public function selectQuestionPopular()
    {
        $this->pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $statement = $this->pdo->query("
        SELECT count(question_id) as nbrep, q.title, q.id FROM answer as a
        JOIN question q
        ON q.id = a.question_id
        GROUP BY q.title
        ORDER BY nbrep desc limit 5;");
        return $statement->fetchAll();
    }
    public function selectQuestionsByKeyword($keyword)
    {
        $statement = $this->pdo->prepare("
        SELECT q.title, q.description FROM question q 
        WHERE q.title LIKE :keyword ");
        $statement->bindValue(':keyword', "%" . $keyword . "%", \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }

  //  public function selectAnswersByIdUser(int $id)
  //  {
  //      $statement = $this->pdo->prepare("
  //      SELECT a.id, a.description FROM answer a
  //      JOIN user u
  //      ON u.id = a.user_id");
  //      $statement->bindValue('id', $id,\PDO::PARAM_INT);
  //      $statement->execute();

  //      return $statement->fetchAll();
  //  }
}

