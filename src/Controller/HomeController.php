<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AnswerManager;
use App\Model\QuestionManager;
use App\Model\TagManager;
use App\Service\ColorGenerator;

class HomeController extends AbstractController
{

    public function index()
    {
        return $this->twig->render('Home/index.html.twig');
    }
    public function questionHome(): string
    {
        $questionManager = new QuestionManager();
        $questions = $questionManager->selectAll('created_at');
        if (isset($_GET['keyword'])) {
            $questions = $questionManager->selectQuestionsByKeyword($_GET['keyword']);
        }
        $colorGenerator = new ColorGenerator();
        $tags = $colorGenerator->generateTagsWithColor();
        $questionManager = new QuestionManager();
        $popularQuestions = $questionManager->selectQuestionPopular();
        return $this->twig->render('Home/index.html.twig', [
            'questions' => $questions,
            'tags'      => $tags,
            'popular_questions' => $popularQuestions,
        ]);
    }

}
