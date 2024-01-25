<?php

namespace App\Controllers;



class Variables extends BaseController
{
    public function postBaseURL()
    {
        return json_encode(base_url());
    }
}