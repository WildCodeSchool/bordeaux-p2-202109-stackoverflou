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


    public function connect(): string
    {
        return $this->twig->render('User/formConnect/html/twig');

    public function profil(int $id): string
    {
        $userManager = new UserManager();
        $profile = $userManager->selectOneById($id);
        return $this->twig->render('User/user.html.twig', ['profile' => $profile]);
    }
}
