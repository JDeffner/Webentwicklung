<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex flex-column flex-sm-row align-items-start align-sm-center">
            <h4>Taskarten</h4>
            <div class="d-flex ms-auto" id="taskarten-table-toolbar">
                <a role="button" class="btn btn-secondary me-1 createTaskartButton" data-bs-toggle="modal" data-bs-target="#createTaskartModal"><i class="fa-solid fa-square-plus"></i> Neu</a>
                <div class="taskarten-buttons-toolbar"></div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover"
                   id="taskartenTable"
                   data-show-columns="true"
                   data-show-toggle="true"
                   data-toggle="table"
                   data-search="true"
                   data-show-refresh="true"
                   data-ajax="taskartenAjaxRequest"
                   data-buttons-toolbar=".taskarten-buttons-toolbar">
                <thead>
                <tr>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="taskart">Taskart</th>
                    <th data-field="taskartenicon">Icon</th>
                    <th data-field="bearbeiten">Bearbeiten</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</main>

    <!-- Create Taskart Modal -->
<?= view_cell('CrudModals::createModal','type=Taskart') ?>

    <!-- Edit Taskart Modal -->
<?= view_cell('CrudModals::editModal','type=Taskart') ?>

    <!-- Delete Taskart Modal -->
<?= view_cell('CrudModals::deleteModal','type=Taskart') ?>

<!-- Toast -->
<?= $this->include('components/CrudToast.php') ?>

<?= $this->endSection() ?>
