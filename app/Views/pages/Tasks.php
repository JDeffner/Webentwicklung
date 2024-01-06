<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Tasks</h4>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h5>Status Initial</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ((isset($tasks) ? $tasks : null) as $item): ?>
                            <tr>
                                <td><?= $item["spalte"] ?></td>
                                <td><?= $item["sortid"] ?></td>
                                <td><?= $item["notizen"] ?></td>
                                <td><?= $item["erinnerungsdatum"] ?></td>
                                <td><?= $item["vorname"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>