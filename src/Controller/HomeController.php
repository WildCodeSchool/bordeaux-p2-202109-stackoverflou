<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\QuestionManager;
use App\Model\TagManager;
use App\Service\ColorGenerator;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Home/index.html.twig');
    }
    public function questionHome(): string
    {
        $questionManager = new QuestionManager();
        $questions = $questionManager->selectAll('title');
        $colorGenerator = new ColorGenerator();
        $tags = $colorGenerator->generateTagsWithColor();
        return $this->twig->render('Home/index.html.twig', [
            'questions' => $questions,
            'tags'      => $tags,
        ]);
    }
}
