<?php

/*return [
    '' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
>>>>>>> ea7248b62e9206c1647f58f7b934cd0d9887a549
    'items/delete' => ['ItemController', 'delete',],
];*/

return [
    '' => ['HomeController', 'index',],
    'user' => ['UserController', 'profil', ['id']],
    'user/create' => ['UserController', 'add',],
    'user/edit' => ['UserController', 'edit', ['id']],
    'question/add' => ['QuestionController','add',],
    'question/show' => ['QuestionController','show', ['id']]
];
