<?php

namespace App\Controllers;
use App\Models\Test;

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
        $testModel = new Test();
        $data['personen'] = $testModel->getData();
        echo view('pages/TestDatabase', $data);
}

}