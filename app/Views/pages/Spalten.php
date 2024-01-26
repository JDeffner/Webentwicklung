<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Spalten</h4>
        </div>
        <div class="card-body">
            <div class="d-flex" id="spalten-table-toolbar">
                <a role="button" class="btn btn-primary mb-3 me-1 createSpalteButton" data-bs-toggle="modal" data-bs-target="#createSpalteModal"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>
                <div class="spalten-buttons-toolbar">
                </div>
            </div>

            <table class="table table-hover table-bordered table-responsive"
                   id="spaltenTable"
                   data-toggle="table"
                   data-height="460"
                   data-ajax="spaltenAjaxRequest"
                   data-search="true"
                   data-pagination="true"
                   data-show-refresh="true"
                   data-show-columns="true"
                   data-show-toggle="true"
                   data-buttons-toolbar=".spalten-buttons-toolbar">
                <thead>
                    <tr>
                        <th scope="col" data-sortable="true" data-field="id">ID</th>
                        <th scope="col" data-sortable="true" data-field="spalte">Spalte</th>
                        <th scope="col" data-sortable="true" data-field="board">Board</th>
                        <th scope="col" data-sortable="true" data-field="sortid">Sortid</th>
                        <th scope="col" data-field="spaltenbeschreibung">Spaltenbeschreibung</th>
                        <th scope="col" data-field="bearbeiten">Bearbeiten</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</main>

<!-- Create Spalte Modal -->
<?= view_cell('CrudModals::createModal', 'type=Spalte') ?>

<!-- Edit Spalte Modal -->
<?= view_cell('CrudModals::editModal','type=Spalte') ?>

<!-- Delete Spalte Modal -->
<?= view_cell('CrudModals::deleteModal','type=Spalte') ?>

<?= $this->endSection() ?>