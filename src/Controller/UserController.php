<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function register(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('trim', $_POST);
            if (empty($user['username'])) {
                $errors['usernameError'] = 'Le champs pseudo doit être remplie';
            }
            if (empty($user['email'])) {
                $errors['emailError'] = 'Le champs mail doit être remplie';
            }
            if (empty($user['password'])) {
                $errors['passwordError'] = 'Le champs mot de passe doit petre remplie';
            }
            if (empty($errors)) {
                $userManager = new UserManager();
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $userId = $userManager->createUser($_POST);
                $userData = $userManager->selectOneById($userId);
                $_SESSION['user'] = $userData;
                header('location: /user?id=' . $_SESSION['user']['id']);
            }
        }
        return $this->twig->render('User/formRegister.html.twig', [
            'register_success' => $_GET['register'] ?? null,
            'errors' => $errors
        ]);
    }

    public function connect(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $userData = $userManager->selectOneByEmail($_POST['email']);
            if (password_verify($_POST['password'], $userData['password'])) {
                $_SESSION['user'] = $userData;
                header('location: /user?id=' . $_SESSION['user']['id']);
                exit();
            } else {
                var_dump('La connexion a échouée');
            }
            header('Location:/');
        }
        return $this->twig->render('User/formConnect.html.twig', ['session' => $_SESSION,]);
    }

    public function logout()
    {
        session_destroy();
        header('location: /');
    }

    public function profil(int $id): string
    {
        $userManager = new UserManager();
        $userData = $userManager->selectOneById($id);
        $userStat = $userManager->NbAnswersByUser();
        return $this->twig->render('User/user.html.twig', [
            'profile' => $userData,
            'stat' => $userStat
        ]);
    }

}
