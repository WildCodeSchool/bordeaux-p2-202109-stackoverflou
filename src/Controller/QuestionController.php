<?php

namespace App\Controller;

use App\Model\QuestionManager;
use App\Model\TagManager;

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


        return $this->twig->render('Question/show.html.twig', [
            'question' => $question,
            'tags' => $tags,
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
}
