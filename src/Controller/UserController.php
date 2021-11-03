<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function profil(int $id): string
    {
        $userManager = new UserManager();
        $profile = $userManager->selectOneById($id);
        return $this->twig->render('User/user.html.twig', ['profile' => $profile]);
    }
}
