<?php

namespace App\Model;

class TagManager extends AbstractManager
{
    public const TABLE = 'tag';
    public function insert(array $tags): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(`name`) 
        VALUES (:name)");
        $statement->bindValue(':name', $tags['name'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $tags): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `name` = :name WHERE id=:id");
        $statement->bindValue(':id', $tags['id'], \PDO::PARAM_INT);
        $statement->bindValue(':name', $tags['name'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
