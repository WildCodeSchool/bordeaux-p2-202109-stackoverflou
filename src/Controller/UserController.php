<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function register(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $profileId = $userManager->createUser($_POST);
            $profile = $userManager->selectOneById($profileId);
            $_SESSION['user'] = $profile;
            header('location: /user/create?id=' . $profileId);
        }
        return $this->twig->render('User/formRegister.html.twig', [
            'register_success' => $_GET['register'] ?? null,
        ]);
    }


    public function connect(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $profile = $userManager->selectOneByEmail($_POST['email']);
            if (password_verify($_POST['password'], $profile['password'])) {
                $_SESSION['user'] = $profile;
            } else {
                var_dump('not ok');
            }
        }
        return $this->twig->render('User/formConnect.html.twig', [
            'session' => $_SESSION
        ]);
    }

    public function logout()
    {
        session_destroy();
        header('location: /');
    }

    public function profil(int $id): string
    {
        $userManager = new UserManager();
        $profile = $userManager->selectOneById($id);
        return $this->twig->render('User/user.html.twig', [
            'profile' => $profile
        ]);
    }
}
