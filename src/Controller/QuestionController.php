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
    public function show(int $id): string
    {
        $questionManager = new questionManager();
        $question = $questionManager->selectOneById($id);

        return $this->twig->render('Question/show.html.twig', ['question' => $question]);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST);die;
            // clean $_POST data
            $question = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $questionManager = new QuestionManager();
            $id = $questionManager->insert($question);
            header('Location:/questions/show?id=' . $id);
        }
        $tagManager = new TagManager();
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
