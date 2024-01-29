<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>

<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex flex-column flex-sm-row align-items-start align-sm-center">
            <h4>Tasks</h4>
            <div class="d-flex ms-auto" id="tasks-table-toolbar">
                <a role="button" class="btn btn-secondary me-1 createTaskButton" data-bs-toggle="modal" data-bs-target="#createTaskModal"><i class="fa-solid fa-square-plus"></i> Neu</a>
                <div class="tasks-buttons-toolbar"></div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered table-responsive"
                   id="tasksTable"
                   data-toggle="table"
                   data-ajax="tasksAjaxRequest"
                   data-search="true"
                   data-pagination="true"
                   data-show-refresh="true"
                   data-show-columns="true"
                   data-show-toggle="true"
                   data-buttons-toolbar=".tasks-buttons-toolbar">
                <thead>
                <tr>
                    <th scope="col" data-sortable="true" data-field="id">ID</th>
                    <th scope="col" data-sortable="true" data-field="task">Task</th>
                    <th scope="col" data-sortable="true" data-field="taskart">Taskart</th>
                    <th scope="col" data-sortable="true" data-field="board">Board</th>
                    <th scope="col" data-sortable="true" data-field="spalte">Spalte</th>
                    <th scope="col" data-sortable="true" data-field="person">Person</th>
                    <th scope="col" data-sortable="true" data-field="erstelldatum">Erstelldatum</th>
                    <th scope="col" data-sortable="true" data-field="erinnerungsdatum">Erinnerungsdatum</th>
                    <th scope="col" data-field="notizen">Notizen</th>
                    <th scope="col" data-field="bearbeiten">Bearbeiten</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</main>

<!-- Create Task Modal -->
<?= view_cell('CrudModals::createModal', 'type=Task') ?>

<!-- Edit Task Modal -->
<?= view_cell('CrudModals::editModal','type=Task') ?>

<!-- Delete Task Modal -->
<?= view_cell('CrudModals::deleteModal','type=Task') ?>

<?= $this->endSection() ?>