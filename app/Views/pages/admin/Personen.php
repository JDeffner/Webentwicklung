<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex flex-column flex-sm-row align-items-start align-sm-center">
            <h4>Personen</h4>
            <div class="d-flex ms-auto" id="personen-table-toolbar">
                <div class="personen-buttons-toolbar"></div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover"
                   id="personenTable"
                   data-show-columns="true"
                   data-show-toggle="true"
                   data-toggle="table"
                   data-search="true"
                   data-show-refresh="true"
                   data-ajax="personenAjaxRequest"
                   data-buttons-toolbar=".personen-buttons-toolbar">
                <thead>
                <tr>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="vorname">Vorname</th>
                    <th data-field="nachname">Nachname</th>
                    <th data-field="email">Email</th>
                    <th data-field="permission" data-sortable="true">Rolle</th>
                    <th data-field="bearbeiten">Bearbeiten</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</main>

    <!-- Edit Person Modal -->
<?= view_cell('CrudModals::editModal','type=Person') ?>

    <!-- Delete Person Modal -->
<?= view_cell('CrudModals::deleteModal','type=Person') ?>

<!-- Toast -->
<?= $this->include('components/CrudToast.php') ?>

<?= $this->endSection() ?>