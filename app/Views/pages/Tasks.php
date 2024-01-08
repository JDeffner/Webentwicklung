<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Tasks</h4>
        </div>
        <div class="card-body">
            <div class="container-fluid">

                <div class="d-flex flex-row flex-nowrap overflow-auto">
                    <?php foreach (($spalten ?? null) as $spalte):
                        if ($spalte['boardsid'] == ($thisBoard ?? 0)) ?>
                        <div class="me-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3><?= $spalte['spalte'] ?></h3>
                                    <small class="mb-0"><?= $spalte['spaltenbeschreibung'] ?></small>
                                </div>
                                <div class="card-body">
                                    <?php foreach (($tasks ?? null) as $oneTask): ?>
                                        <tr>
                                            <td><?= $oneTask["tasks"] ?></td>
                                            <td><?= $oneTask["sortid"] ?></td>
                                            <td><?= $oneTask["notizen"] ?></td>
                                            <td><?= $oneTask["erinnerungsdatum"] ?></td>
                                            <td><?= $oneTask["vorname"] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>