<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function createUser(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
            "(`username`, `email`, `password`, `created_at`, `is_admin`)    
        VALUES(:username, :email, :password, NOW(), 0)");
        $statement->bindValue(':username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $user['password'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneByEmail(string $email)
    {
        $statement = $this->pdo->prepare('SELECT * FROM' . self::TABLE . 'WHERE email=:email');
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `username` = :username WHERE id=:id");
        $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('title', $user['username'], \PDO::PARAM_STR);
        return $statement->execute();
    }
}
