<?php

namespace App\Controllers;



class ErrorController extends BaseController
{
    public function index()
    {
        echo view('errors/AccessDenied');
    }


}