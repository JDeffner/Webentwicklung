<?php

namespace App\Controllers\Admin;
use ReflectionException;
use App\Controllers\BaseController;


class TaskartenController extends BaseController {

        public function getTaskarten() {
            $data = [
                'title' => 'Taskarten',
            ];
//            echo view('pages/admin/Taskarten', $data);
            echo view('pages/dev/welcome_message');
        }

        public function getTaskartenRawData() {
            return json_encode($data);
        }

        public function postTaskartErstellen() {
            return json_encode($data);
        }

        public function postTaskartBearbeiten($taskartenid) {
            return json_encode($data);
        }

        public function postTaskartLoeschen($taskartenid) {
            return json_encode($data);
        }

        public function postTaskartenInfo($taskartenid) {
            return json_encode($data);
        }
}