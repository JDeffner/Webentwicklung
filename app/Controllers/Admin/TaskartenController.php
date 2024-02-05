<?php

namespace App\Controllers\Admin;
use ReflectionException;
use App\Models\TaskartenModel;
use App\Controllers\BaseController;


class TaskartenController extends BaseController {

        public function getTaskarten() {
            $data = [
                'title' => 'Taskarten',
            ];
            echo view('pages/admin/Taskarten', $data);
        }

        public function getTaskartenRawData() {
            $taskartenModel = new TaskartenModel();
            $data['taskarten'] = $taskartenModel->findAll();
            return json_encode($data);
        }

    /**
     * @throws ReflectionException
     */
    public function postTaskartErstellen() {
            $taskartenModel = new TaskartenModel();
            if($taskartenModel->save($_POST)){
                $data['taskartenid'] = $taskartenModel->getInsertID();
                $data['tableName'] = 'taskarten';
                $data['action'] =  'erstellt';
                $data['successfulValidation'] = true;
            } else {
                $data['error'] = $taskartenModel->errors();
                $data['successfulValidation'] = false;
            }
            return json_encode($data);
        }

    /**
     * @throws ReflectionException
     */
    public function postTaskartBearbeiten($taskartenid) {
            $taskartenModel = new TaskartenModel();
            if($taskartenModel->update($taskartenid, $_POST)){
                $data['tableName'] = 'taskarten';
                $data['action'] = 'bearbeitet';
                $data['successfulValidation'] = true;
            } else {
                $data['error'] = $taskartenModel->errors();
                $data['successfulValidation'] = false;
            }
            return json_encode($data);
        }

        public function postTaskartLoeschen($taskartenid) {
            $taskartenModel = new TaskartenModel();
            if($taskartenModel->delete($taskartenid)) {
                $data['action'] = 'gelöscht';
                $data['successfulValidation'] = true;
            } else {
                $data['error'] = [ 'deletion' => 'Taskart konnte nicht gelöscht werden, da sie noch einer Task zugewiesen ist'];
                $data['successfulValidation'] = false;
            }
            return json_encode($data);
        }

        public function postTaskartenInfo($taskartenid) {
            $taskartenModel = new TaskartenModel();
            $data['taskart'] = $taskartenModel->find($taskartenid);
            return json_encode($data);
        }
}