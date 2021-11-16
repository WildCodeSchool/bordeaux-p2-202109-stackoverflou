<?php

namespace App\Controller;

use App\Model\AnswerManager;

class AnswerController extends AbstractController
{
    public function rankUp():void
    {
        $answerManager = new AnswerManager();
        $answerManager->rankUp($_POST['answerId']);
        header("Location: /questions/rank");
    }

    public function rankByAnswer(): int
    {
        $answerManager = new AnswerManager();
        $answerManager->NbRankByAnswers();

    }
}