<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
    <main class="container-fluid">
        <div class="card ms-3 me-3">
            <div class="card-header">
                <h4>List of Users</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover"
                       data-show-columns="true"
                       data-show-toggle="true"
                       data-toggle="table"
                       data-search="true"
                       data-toolbar="#toolbar">
                    <thead>
                    <tr>
                        <th data-sortable="true">ID</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ((isset($personen) ? $personen : null) as $item): ?>
                        <tr>
                            <td><?= $item["id"] ?></td>
                            <td><?= $item["vorname"] ?></td>
                            <td><?= $item["nachname"] ?></td>
                            <td><?= $item["email"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
<?= $this->endSection() ?>