<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Spalten</h4>
        </div>
        <div class="card-body">
<!--            <a role="button" class="btn btn-primary mb-2" href="--><?php //echo base_url('/spalten/erstellen');?><!--">Erstellen</a>-->
            <a role="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSpalteModal"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>

            <table class="table table-hover table-bordered table-responsive rounded-table"
                   data-show-columns="true"
                   data-show-toggle="true"
                   data-toggle="table"
                   data-search="true"
                   data-toolbar="#toolbar">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Spalte</th>
                        <th scope="col">Board</th>
                        <th scope="col">Sortid</th>
                        <th scope="col">Spaltenbeschreibung</th>
                        <th scope="col">Bearbeiten</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($spalten ?? null) as $oneSpalte): ?>
                        <tr>
                            <input type="hidden" name="id" value="<?= $oneSpalte['id'] ?>">
                            <input type="hidden" name="board" value="<?= $oneSpalte['board'] ?>">
                            <input type="hidden" name="sortid" value="<?= $oneSpalte['sortid'] ?>">
                            <input type="hidden" name="spalte" value="<?= $oneSpalte['spalte'] ?>">
                            <input type="hidden" name="spaltenbeschreibung" value="<?= $oneSpalte['spaltenbeschreibung'] ?>">
                            <td><?= $oneSpalte['id'] ?></td>
                            <td><?= $oneSpalte['spalte'] ?></td>
                            <td><?= $oneSpalte['board'] ?></td>
                            <td><?= $oneSpalte['sortid'] ?></td>
                            <td><?= $oneSpalte['spaltenbeschreibung'] ?></td>
                            <td>
                                <i class="fa-solid fa-pen-to-square editTaskButton" data-bs-toggle="modal" data-bs-target="#editSpalteModal"
                                   data-spalte="<?= $oneSpalte['spalte'] ?>"
                                   data-spaltenbeschreibung="<?= $oneSpalte['spaltenbeschreibung'] ?>"
                                   data-id="<?= $oneSpalte['id'] ?>"
                                   data-board="<?= $oneSpalte['boardid'] ?>"
                                   data-sortid="<?= $oneSpalte['sortid'] ?>"></i>
                                <i class="fa-solid fa-trash deleteSpalteButton" data-bs-toggle="modal" data-bs-target="#deletionSpalteModal" data-task-id="<?= $oneSpalte['id'] ?>" data-task-name="<?= $oneSpalte['spalte'] ?>"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Create spalte Modal -->
    <div class="modal fade" id="createSpalteModal" tabindex="-1" aria-labelledby="createSpalteModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Neue Spalte erstellen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $formAction = base_url('spalten/erstellen');
                    include APPPATH . 'Views/components/SpalteForm.php';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit spalte Modal -->
    <div class="modal fade" id="editSpalteModal" tabindex="-1" aria-labelledby="editSpalteModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Spalte bearbeiten</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    //                    $formAction = base_url('tasks/bearbeiten/');
                    include APPPATH . 'Views/components/SpalteForm.php';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Deletion Modal -->
    <div class="modal fade" id="deletionSpalteModal" tabindex="-1" aria-labelledby="deletionModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <form id="deleteTaskForm" method="post" action="">
                        <button type="submit" class="btn btn-warning delete-task-btn">Spalte löschen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.editTaskButton').click(function () {
                var id = $(this).data('id');
                var board = $(this).data('board');
                var sortid = $(this).data('sortid');
                var spalte = $(this).data('spalte');
                var spaltenbeschreibung = $(this).data('spaltenbeschreibung');
                $('#editModalLabel').text('Spalte ' + spalte + ' bearbeiten');
                $('#editSpalteModal').find('#SpaltenName').val(spalte);
                $('#editSpalteModal').find('#spaltenBeschreibung').val(spaltenbeschreibung);
                $('#editSpalteModal').find('#sortid').val(sortid);
                console.log(board);
                $('#editSpalteModal').find('#Board').val(board);
                $('#editSpalteModal').find('form').attr('action', '<?php echo base_url('spalten/bearbeiten/'); ?>' + id);
            });
        });

        $(document).ready(function () {
            $('.deleteSpalteButton').click(function () {
                var id = $(this).data('task-id');
                var name = $(this).data('task-name');
                $('#deleteModalLabel').text('Spalte ' + name + ' löschen?');
                $('#deleteTaskForm').attr('action', '<?php echo base_url('spalten/loeschen/'); ?>' + id);
            });
        });
    </script>


</main>
<?= $this->endSection() ?>