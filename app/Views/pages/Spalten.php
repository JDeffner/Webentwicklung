<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Spalten</h4>
        </div>
        <div class="card-body">
            <a role="button" class="btn btn-primary mb-2" href="<?php echo base_url('/spalten/erstellen');?>">Erstellen</a>

            <table class="table table-hover table-bordered table-responsive rounded-table"
                   data-show-columns="true"
                   data-show-toggle="true"
                   data-toggle="table"
                   data-search="true"
                   data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Board</th>
                        <th scope="col">Sortid</th>
                        <th scope="col">Spalte</th>
                        <th scope="col">Spaltenbeschreibung</th>
                        <th scope="col">Bearbeiten</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Allgemeine Todos</td>
                        <td>100</td>
                        <td>zu besprechen</td>
                        <td>noch zu besprechende Todos</td>
                        <td>
                            <i class="fa-solid fa-pen-to-square"></i>
                            <i class="fa-solid fa-trash"></i>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            2
                        </th>
                        <td>Allgemeine Todos</td>
                        <td>200</td>
                        <td>In Bearbeitung</td>
                        <td>Todos die aktuell bearbeitet werden</td>
                        <td>
                            <i class="fa-solid fa-pen-to-square"></i>
                            <i class="fa-solid fa-trash"></i>
                        </td>
                    </tr>
                    <?php for ($i = 3; $i <= 30; $i++) { ?>
                        <tr>
                            <th scope="row">
                                <?php echo $i; ?>
                            </th>
                            <td>Allgemeine Todos</td>
                            <td><?php echo $i + 100; ?></td>
                            <td>Spalte <?php echo $i; ?></td>
                            <td>Spaltenbeschreibung <?php echo $i; ?></td>
                            <td>
                                <i class="fa-solid fa-pen-to-square"></i>
                                <i class="fa-solid fa-trash"></i>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</main>
<?= $this->endSection() ?>