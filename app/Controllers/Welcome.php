<?php

namespace App\Controllers;
use App\Models\Personen;


class Welcome extends BaseController
{
    public function index()
    {
        echo view('welcome_message');
    }

    public function viewGruppennummer(){
        var_dump(04);
    }


//    public function testConnection() {
//        $query = $this->db->get('tasks'); // Replace 'your_table_name' with an actual table name
//        print_r($query->result()); // Print the query result to verify the connection
//    }
public function testDatabase() {
        $testModel = new Personen();
        $data['personen'] = $testModel->getAllData();
        echo view('pages/TestDatabase', $data);
}

public function test($string)
{
    var_dump($string);
}

public function abweisung()
{
    $data = [
        'title' => 'Login',
    ];
    echo view('pages/Abweisung', $data);
}

}