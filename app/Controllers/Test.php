<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function gettestMethod(){
        var_dump("das ist ein Test");
    }
}