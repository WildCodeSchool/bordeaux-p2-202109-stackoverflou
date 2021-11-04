<?php

/*return [
    '' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
];*/

return [
    '' => ['HomeController','questionHome'],
    'user' => ['UserController', 'profil', ['id']],
    'user/create' => ['UserController', 'register',],
    'user/edit' => ['UserController', 'edit', ['id']],
    'questions/add' => ['QuestionController','add',],
    'questions/show' => ['QuestionController','show', ['id']],
    'questions/edit' => ['QuestionController','edit', ['id']],
    'questions' => ['QuestionController', 'index',]
];
