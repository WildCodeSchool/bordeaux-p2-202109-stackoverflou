<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function createUser(array $user): int
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
            "(`username`, `email`, `password`, `created_at`, `is_admin`, `pseudo_github`)    
        VALUES(:username, :email, :password, NOW(), 0, :pseudo_github)");
        $statement->bindValue(':username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue(':pseudo_github', $user['pseudo_github'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneByEmail(string $email)
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->prepare('SELECT * FROM ' . self::TABLE . ' WHERE email=:email');
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function update(array $user): bool
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `username` = :username WHERE id=:id");
        $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);
        $statement->bindValue('title', $user['username'], \PDO::PARAM_STR);
        return $statement->execute();
    }

    public function nbAnswersByUser()
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->query("
        SELECT count(answer.user_id) as nbAnswer, u.username FROM camelchest.answer
        JOIN user u
        ON answer.user_id = u.id
        group by u.id;");
        return $statement->fetchAll();
    }

    public function communityStats()
    {
        $statement = $this->pdo->query('SET GLOBAL FOREIGN_KEY_CHECKS=0;');
        $statement->execute();

        $statement = $this->pdo->query("
        SELECT u.id,u.username,count(a.user_id) answers,u.pseudo_github, count(q.user_id) 
        questions, sum(a.ranking) likes 
        FROM user u
        JOIN answer a
        ON u.id = a.user_id
        JOIN question q
        ON u.id = q.user_id
        GROUP BY u.id;");
        return $statement->fetchall();
    }
}
