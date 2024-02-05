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
        return view('components/CrudModal', $data);
    }

    public function editModal(string $type)
    {
        $data = [
            'modalType' => $type,
            'modalMessage' => $type.' ??? bearbeiten',
            'modalAction' => 'edit',
        ];
        return view('components/CrudModal', $data);
    }

    public function deleteModal(string $type)
    {
        $data = [
            'modalType' => $type,
            'modalMessage' => $type.' ??? löschen',
            'modalAction' => 'delete',
        ];
        return view('components/CrudModal', $data);
    }

    public function copyModal(string $type)
    {
        $data = [
            'modalType' => $type,
            'modalMessage' => $type.' ??? kopieren',
            'modalAction' => 'copy',
        ];
        return view('components/CrudModal', $data);
    }
}
