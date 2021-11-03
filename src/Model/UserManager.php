<?php

namespace App\Model;

class userManager extends AbstractManager
{

public const TABLE = 'user';

public function createUser(array $users):int
{
    $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE . "(`username`,`email`,`password`,`create_time`)
    VALUES(:username,:email,:password,NOW())");
    $statement->bindValue(':username', $users['username'], \PDO::PARAM_STR);
    $statement->bindValue(':email', $users['email'], \PDO::PARAM_STR);
    $statement->execute();
    return (int)$this->pdo->lastInsertId();
}

public function update(array $user): bool
{
    $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `username` = :username WHERE id=:id");
    $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
    $statement->bindValue('title', $user['username'], \PDO::PARAM_STR);

    return $statement->execute();
}
}