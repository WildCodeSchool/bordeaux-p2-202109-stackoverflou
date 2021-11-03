<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function register(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $userManager->createUser($_POST);
        }
        return $this->twig->render('User/formRegister.html.twig');
    }

    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `username` = :username WHERE id=:id");
        $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
        $statement->bindValue('username', $user['username'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function connect(): string
    {
        return $this->twig->render('User/formConnect/html/twig');
    }
}
