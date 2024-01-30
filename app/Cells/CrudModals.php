<?php

namespace App\Cells;

class CrudModals
{
    // ...

    public function createModal(string $type)
    {
        $data = [
            'modalType' => $type,
            'modalMessage' => 'Neues ??? erstellen',
            'modalAction' => 'create',
        ];
        return view('components/CRUDModal', $data);
    }

    public function editModal(string $type)
    {
        $data = [
            'modalType' => $type,
            'modalMessage' => $type.' ??? bearbeiten',
            'modalAction' => 'edit',
        ];
        return view('components/CRUDModal', $data);
    }

    public function deleteModal(string $type)
    {
        $data = [
            'modalType' => $type,
            'modalMessage' => $type.' ??? löschen',
            'modalAction' => 'delete',
        ];
        return view('components/CRUDModal', $data);
    }
}
