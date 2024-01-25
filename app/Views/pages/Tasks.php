<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex align-items-center">
            <h4>Tasks</h4>
            <div class="dropdown ms-auto">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $boardName ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php foreach (($boards ?? null) as $oneBoard): ?>
                        <li><a class="dropdown-item" href="<?= base_url('tasks/').$oneBoard['id'] ?>"><?= $oneBoard['board'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <a role="button" class="btn btn-primary mb-3 createTaskButton" data-bs-toggle="modal" data-bs-target="#createTaskModal"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>
            <div class="d-flex flex-row flex-nowrap overflow-auto prettyScrollbar">
                <?php foreach (($spaltenForBoard ?? null) as $oneSpalte): ?>
                    <div class="me-3">
                        <div class="card">
                            <div class="card-header">
                                <h3><?= $oneSpalte['spalte'] ?></h3>
                                <small class="mb-0"><?= $oneSpalte['spaltenbeschreibung'] ?></small>
                            </div>
                            <div class="card-body spaltenBody">
                                <?php foreach (($tasks ?? null) as $oneTask):
                                    if ($oneTask['spaltenid'] == $oneSpalte['id']) {  ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Name</th>
                                                    <td><?= $oneTask['task'] ?></td>
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

                                            <i data-bs-target="#editTaskModal" class="fa-solid fa-pen-to-square editTaskButton"
                                                data-task="<?= $oneTask['task'] ?>"
                                                data-taskartenid="<?= $oneTask['taskartenid'] ?>"
                                                data-taskartenicon="<?= $oneTask['taskartenicon'] ?>"
                                                data-taskart="<?= $oneTask['taskart'] ?>"
                                                data-spaltenid="<?= $oneTask['spaltenid'] ?>"
                                                data-personenid="<?= $oneTask['personenid'] ?>"
                                                data-erinnerungsdatum="<?= $oneTask['erinnerungsdatum'] ?>"
                                                data-erinnerung="<?= $oneTask['erinnerung'] ?>"
                                                data-notizen="<?= $oneTask['notizen'] ?>"
                                                data-id="<?= $oneTask['id'] ?>"
                                                data-bs-toggle="modal"></i>
                                            <i class="fa-solid fa-trash deleteTaskButton" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" data-task-id="<?= $oneTask['id'] ?>" data-boards-id="<?= $oneTask['boardsid'] ?>" data-task-name="<?= $oneTask['task'] ?>"></i>

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

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createTaskModalLabel">Neue Task erstellen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    include APPPATH . 'Views/components/TaskForm.php';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTaskModalLabel">Task bearbeiten</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    include APPPATH . 'Views/components/TaskForm.php';
                    ?>
                </div>
            </div>
        </div>
    </div>



    <!-- Deletion Modal -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteTaskModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <form id="deleteTaskForm" method="post" action="">
                        <button type="submit" class="btn btn-warning delete-task-btn">Task löschen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
<script>


 // Create Task Modal
 $(document).ready(function () {
     $('.createTaskButton').click(function () {
         var createTaskModal = $('#createTaskModal');
         createTaskModal.find('form').attr('data-send-to', '<?php echo base_url('tasks/erstellen'); ?>');
     });
 });


// Edit Task Modal
 $(document).ready(function () {
    $('.editTaskButton').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('task');
        var taskartenid = $(this).data('taskartenid');
        var taskartenicon = $(this).data('taskartenicon');
        var taskart = $(this).data('taskart');
        var spalte = $(this).data('spaltenid');
        var person = $(this).data('personenid');
        var erinnerungDatum = $(this).data('erinnerungsdatum');
        var erinnerung = $(this).data('erinnerung');
        var notiz = $(this).data('notizen');
        var editTaskModal = $('#editTaskModal');

        editTaskModal.find('#task').val(name);
        editTaskModal.find('#taskartenid').val(taskartenid);
        editTaskModal.find("#btnTaskart span").html('<i class="' + taskartenicon + '"></i>' + ' ' + taskart);
        editTaskModal.find('#spaltenid').val(spalte);
        editTaskModal.find('#personenid').val(person);
        editTaskModal.find('#erinnerungsdatum').val(erinnerungDatum);
        if(erinnerung == '1') {
            editTaskModal.find('#erinnerung').prop('checked', true)
            editTaskModal.find('#erinnerungsdatum').removeAttr('disabled');
        } else {
            editTaskModal.find('#erinnerung').prop('checked', false)
            editTaskModal.find('#erinnerungsdatum').attr('disabled', '');

        }
        editTaskModal.find('#notizen').val(notiz);
        editTaskModal.find('#editTaskModalLabel').text('Task "'+name+'" bearbeiten');
        editTaskModal.find('form').attr('data-send-to', '<?= base_url('tasks/bearbeiten/') ?>'+id);

    });
});

 // Erinnerung Checkbox disable/enable Erinnerungsdatum
 $('.form-check-input').on('change', function() {

    if ($(this).prop('checked')) {
        $('.erinnerungsdatum').removeAttr('disabled');
    } else {

        $('.erinnerungsdatum').attr('disabled', '');
    }
    });

// Delete Task Modal
$(document).ready(function () {
 $('.deleteTaskButton').click(function() {
     var taskId = $(this).data('task-id');
     var taskName = $(this).data('task-name');
        var boardId = $(this).data('boards-id');

     $('#deleteTaskForm').attr('action', `<?php echo base_url('/tasks/loeschen/'); ?>${boardId}/${taskId}`);
     $('#deleteTaskModalLabel').text(`Willst du die Task "${taskName}" wirklich löschen?`);
 });
});
</script>
<?= $this->endSection() ?>