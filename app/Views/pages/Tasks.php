<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Tasks</h4>
        </div>
        <div class="card-body">
            <a role="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createTaskModal"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>
            <div class="d-flex flex-row flex-nowrap overflow-auto prettyScrollbar">
                <?php foreach (($spaltenForBoard ?? null) as $oneSpalte): ?>
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
                                            <input type="hidden" id="taskid" value="<?php echo $oneTask['id'] ?>">
                                            <input type="hidden" id="taskname" value="<?php echo $oneTask['tasks'] ?>">
                                            <input type="hidden" id="taskperson" value="<?php echo $oneTask['personenid'] ?>">
                                            <input type="hidden" id="taskspalte" value="<?php echo $oneTask['spaltenid'] ?>">
                                            <input type="hidden" id="taskerinnerung-datum" value="<?php echo $oneTask['erinnerungsdatum'] ?>">
                                            <input type="hidden" id="taskerinnerung" value="<?php echo $oneTask['erinnerung'] ?>">
                                            <input type="hidden" id="tasknotiz" value="<?php echo $oneTask['notizen'] ?>">
                                            <input type="hidden" id="tasktaskart" value="<?php echo $oneTask['taskartenid'] ?>">
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

                                            <i data-bs-toggle="modal" data-bs-target="#editTaskModal" class="fa-solid fa-pen-to-square editTaskButton"></i>
                                            <i class="fa-solid fa-trash deleteTaskButton" data-bs-toggle="modal" data-bs-target="#deletionModal" data-task-id="<?= $oneTask['id'] ?>" data-task-name="<?= $oneTask['tasks'] ?>"></i>

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
                    <h1 class="modal-title fs-5" id="createModalLabel">Neue Task erstellen</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $formAction = base_url('tasks/erstellen');
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
                    <h1 class="modal-title fs-5" id="editModalLabel">Task bearbeiten</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
//                    $formAction = base_url('tasks/bearbeiten/');
                    include APPPATH . 'Views/components/TaskForm.php';
                    ?>
                </div>
            </div>
        </div>
    </div>



    <!-- Deletion Modal -->
    <div class="modal fade" id="deletionModal" tabindex="-1" aria-labelledby="deletionModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel"></h1>
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
     var wantReminder = false;
        // Get all edit buttons
     $('.editTaskButton').on('click', function() {
         var id = $(this).siblings()[0].value;
         var name = $(this).siblings()[1].value;
         var person = $(this).siblings()[2].value;
         var spalte = $(this).siblings()[3].value;
         var erinnerungDatum = $(this).siblings()[4].value;
         var erinnerung = $(this).siblings()[5].value;
         var notiz = $(this).siblings()[6].value;
         var taskart = $(this).siblings()[7].value;
         var editTaskModal = $('#editTaskModal');

         editTaskModal.find('#TaskName').val(name);
         editTaskModal.find('#TaskArt').val(taskart);
         editTaskModal.find('#Spalte').val(spalte);
         editTaskModal.find('#ZustaendigePerson').val(person);
         editTaskModal.find('#erinnerungsdatum').val(erinnerungDatum);
         if(erinnerung === '1') {
             editTaskModal.find('#erinnerung').attr('checked', '');

             // $('#erinnerungsdatum').removeAttr('disabled');
             wantReminder = true;
         } else {
             editTaskModal.find('#erinnerung').removeAttr('checked');
             // $('#erinnerungsdatum').attr('disabled', '');
             wantReminder = false;
         }
         console.log(wantReminder);
         editTaskModal.find('#Notizen').val(notiz);
         editTaskModal.find('form').attr('action', '<?= base_url('tasks/bearbeiten/') ?>'+id);

     });

     $('#erinnerung').on('change', function() {
         console.log('click');
         if (wantReminder) {

             $('#erinnerungsdatum').attr('disabled', '');
             wantReminder = false;
         } else {
             $('#erinnerungsdatum').removeAttr('disabled');
             wantReminder = true;
         }
     });

     // Get all delete buttons
     $('.deleteTaskButton').on('click', function() {
         var taskId = $(this).data('task-id');
         var taskName = $(this).data('task-name');

         $('#deleteTaskForm').attr('action', `<?php echo base_url('/tasks/loeschen/'); ?>${taskId}`);
         $('#deleteModalLabel').text(`Willst du die Task "${taskName}" wirklich löschen?`);
     });
 </script>
<?= $this->endSection() ?>