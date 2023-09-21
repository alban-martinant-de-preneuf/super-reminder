<?php

namespace App\Controller;

class ViewController
{
    public function getHome()
    {
        require_once 'src/View/home.php';
    }

    public function getLoginForm()
    {
        require_once 'src/View/loginForm.php';
    }

    public function getRegisterForm()
    {
        require_once 'src/View/registerForm.php';
    }

    public function getListPage()
    {
        require_once 'src/View/listsPages.php';
    }
}

