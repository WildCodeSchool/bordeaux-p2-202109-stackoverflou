<?php

namespace App\Controller;

use App\Model\AnswerManager;
use App\Model\QuestionManager;
use App\Model\TagManager;
use App\Service\ColorGenerator;

class QuestionController extends AbstractController
{

    public function index(): string
    {
        $questionManager = new QuestionManager();
        $questions = $questionManager->selectAll('title');

        return $this->twig->render('Question/index.html.twig', ['questions' => $questions]);
    }


    /**
     * Show informations for a specific question
     */
    public function show(int $questionId): string
    {
        $questionManager = new QuestionManager();
        $tagManager = new TagManager();
        $tags = $tagManager->selectTagsByQuestionId($questionId);
        $question = $questionManager->selectOneById($questionId);
        $colorGenerator = new ColorGenerator();
        $answerManager = new AnswerManager();
        return $this->twig->render('Question/show.html.twig', [
            'question' => $question,
            'tags'     => $colorGenerator->generateTagsWithColor($tags),
            'answers'  => $answerManager->getAnswersByQuestionId($questionId),
        ]);
    }
    public function showTags(int $questionId): string
    {
        $questionManager = new QuestionManager();
        $questions = $questionManager->selectQuestionsByTag($questionId);
        return $this->twig->render('Question/tags.html.twig', [
            'questions' => $questions,
        ]);
    }


    /**
     * Edit a specific question
     */
    public function edit(int $id): string
    {
        $questionManager = new QuestionManager();
        $question = $questionManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $question = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $questionManager->update($question);
            header('Location: /questions/show?id=' . $id);
        }

        return $this->twig->render('Question/edit.html.twig', [
            'question' => $question,
        ]);
    }


    /**
     * Add a new question
     */
    public function add(): string
    {
        $tagManager = new TagManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            // $question = array_map('trim', $_POST);
            //TODO clean post data
            $question = $_POST;
            // TODO validations (length, format...)
            $question['user_id'] = $_SESSION['user']['id'];
            // if validation is ok, insert and redirection
            $questionManager = new QuestionManager();
            $questionId = $questionManager->insert($question);
            $tags = $_POST['tags'];
            foreach ($tags as $tagId) {
                $tagManager->bindTagWithQuestion($tagId, $questionId);
            }

            header('Location:/questions/show?id=' . $questionId);
        }

        $tags = $tagManager->selectAll('name');
        return $this->twig->render('Question/add.html.twig', [
            'tags' => $tags,
        ]);
    }


    /**
     * Delete a specific question
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $questionManager = new QuestionManager();
            $questionManager->delete((int)$id);
            header('Location:/questions');
        }
    }

    public function addAnswer($questionId): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $answer = $_POST;
            $answer['user_id'] = $_SESSION['user']['id'];
            $answerManager = new AnswerManager();
            $answerManager->insert($answer);
            header('Location: /questions/show?id=' . $questionId);
        }
            return $this->twig->render('Question/add_answer.html.twig', [
                'question_id' => $questionId,
            ]);
    }

}
