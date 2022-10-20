<?php

namespace App\Modules\Scorpio\Items;


use App\Models\Post;
use App\Models\User;
use Crm\Views\View;

class Index
{
    protected View $view;


    public function __construct()
    {
        $this->view = new View();
    }


    public function start($map)
    {

//        $posts = User::posts();
        $user = Post::user();
        var_dump($user);

//        var_dump($map);
        return __METHOD__;
    }
}