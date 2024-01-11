<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Tasks</h4>
        </div>
        <div class="card-body">
            <a role="button" class="btn btn-primary mb-3" href="<?php echo base_url('/tasks/erstellen');?>"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>
            <div class="d-flex flex-row flex-nowrap overflow-auto">
                <?php foreach (($spalten ?? null) as $oneSpalte):
//                        if ($oneSpalte['boardsid'] == ($thisBoard ?? 0))
                        ?>
                    <div class="me-3">
                        <div class="card">
                            <div class="card-header">
                                <h3><?= $oneSpalte['spalte'] ?></h3>
                                <small class="mb-0"><?= $oneSpalte['spaltenbeschreibung'] ?></small>
                            </div>
                            <div class="card-body">
                                <?php foreach (($tasks ?? null) as $oneTask):
                                    if ($oneTask['spaltenid'] == $oneSpalte['id']) {  ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Name</th>
                                                    <td><?= $oneTask['tasks'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Notiz</th>
                                                    <td><?= $oneTask['notizen'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Erinnerungsdatum</th>
                                                    <td><?= $oneTask['erinnerungsdatum'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Zugeteilte Person</th>
                                                    <td><?= $oneTask['vorname'] ?> <?= $oneTask['nachname'] ?></td>
                                                </tbody>
                                            </table>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <i class="fa-solid fa-trash" data-bs-toggle="modal" data-bs-target="#deletionModal<?= $oneTask['id'] ?>" data-task-id="<?= $oneTask['id'] ?>"></i>
                                            <div class="modal fade" id="deletionModal<?= $oneTask['id'] ?>" tabindex="-1" aria-labelledby="deletionModal<?= $oneTask['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="deleteModalLabel<?= $oneTask['id'] ?>">Willst du die Task "<?= $oneTask['tasks'] ?>" wirklich löschen?</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <!--                                                        <div class="modal-body">-->
                                                        <!--                                                            -->
                                                        <!--                                                        </div>-->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                                            <form id="deleteTaskForm<?= $oneTask['id'] ?>" method="post" action="<?php echo base_url('/tasks/loeschen/' . $oneTask['id']); ?> ">
                                                                <button type="submit" class="btn btn-warning delete-task-btn">Task löschen</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php } endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<!--    <div class="modal fade" id="deletionModal" tabindex="-1" aria-labelledby="deletionModal" aria-hidden="true">-->
<!--        <div class="modal-dialog modal-dialog-centered">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <h1 class="modal-title fs-5" id="exampleModalLabel">Willst du die Task wirklich löschen?</h1>-->
<!--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--                </div>-->
<!--                <!--                                                        <div class="modal-body">-->-->
<!--                <!--                                                            -->-->
<!--                <!--                                                        </div>-->-->
<!--                <div class="modal-footer">-->
<!--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>-->
<!--                    <form id="deleteTaskForm" method="post" action="">-->
<!--                        <button type="submit" class="btn btn-warning delete-task-btn" data-task-id="">Task löschen</button>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->


 </main>
<?= $this->endSection() ?>