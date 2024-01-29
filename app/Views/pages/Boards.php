<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex flex-column flex-sm-row align-items-start align-sm-center">
            <h4>Boards</h4>
            <div class="d-flex ms-auto" id="boards-table-toolbar">
                <a role="button" class="btn btn-secondary me-1 createBoardButton" data-bs-toggle="modal" data-bs-target="#createBoardModal"><i class="fa-solid fa-square-plus"></i> Neu</a>
                <div class="boards-buttons-toolbar"></div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered table-responsive"
                   id="boardsTable"
                   data-toggle="table"
                   data-ajax="boardsAjaxRequest"
                   data-search="true"
                   data-pagination="true"
                   data-buttons-toolbar=".boards-buttons-toolbar">
                <thead>
                    <tr>
                        <th scope="col" data-sortable="true" data-field="id">ID</th>
                        <th scope="col" data-sortable="true" data-field="board">Board</th>
                        <th scope="col" data-field="bearbeiten">Bearbeiten</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</main>

<!-- Create Board Modal -->
<?= view_cell('CrudModals::createModal', 'type=Board') ?>

<!-- Edit Board Modal -->
<?= view_cell('CrudModals::editModal','type=Board') ?>

<!-- Delete Board Modal -->
<?= view_cell('CrudModals::deleteModal','type=Board') ?>

<?= $this->endSection() ?>
