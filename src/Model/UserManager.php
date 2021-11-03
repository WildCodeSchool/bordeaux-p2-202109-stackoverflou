<?php

namespace App\Model;

class userManager extends AbstractManager
{
    public const TABLE = 'user';

    public function createUser(array $user):int
{
    $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE . "(`username`,`email`,`password`,`created_at`, `is_admin`)
    VALUES(:username,:email,:password,NOW(), 0)");
    $statement->bindValue(':username', $user['username'], \PDO::PARAM_STR);
    $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
    $statement->bindValue(':password', $user['password'], \PDO::PARAM_STR);
    $statement->execute();
    return (int)$this->pdo->lastInsertId();
}
}