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
                                            <input type="hidden" id="taskid" name="id" value="<?php echo $oneTask['id'] ?>">
                                            <input type="hidden" id="taskname" name="tasks" value="<?php echo $oneTask['tasks'] ?>">
                                            <input type="hidden" id="taskperson" name="personenid" value="<?php echo $oneTask['personenid'] ?>">
                                            <input type="hidden" id="taskspalte" name="spaltenid" value="<?php echo $oneTask['spaltenid'] ?>">
                                            <input type="hidden" id="taskerinnerung-datum" name="erinnerungsdatum" value="<?php echo $oneTask['erinnerungsdatum'] ?>">
                                            <input type="hidden" id="taskerinnerung" name="erinnerung" value="<?php echo $oneTask['erinnerung'] ?>">
                                            <input type="hidden" id="tasknotiz" name="notizen" value="<?php echo $oneTask['notizen'] ?>">
                                            <input type="hidden" id="tasktaskart" name="taskartenid" value="<?php echo $oneTask['taskartenid'] ?>">
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
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                                data-task-id="<?= $oneTask['id'] ?>"
                                                data-task-name="<?= $oneTask['tasks'] ?>" data-task-person="<?= $oneTask['personenid'] ?>"
                                                data-task-spalte="<?= $oneTask['spaltenid'] ?>"
                                                data-task-erinnerung-datum="<?= $oneTask['erinnerungsdatum'] ?>" data-task-erinnerung="<?= $oneTask['erinnerung'] ?>"
                                                data-task-notiz="<?= $oneTask['notizen'] ?>" data-task-taskart="<?= $oneTask['taskartenid'] ?>"
                                                class="editTaskButton">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
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

     $('.editTaskButton').on('click', function() {
         var id = $(this).siblings()[0].value;
         var name = $(this).siblings()[1].value;
         var person = $(this).siblings()[2].value;
         var spalte = $(this).siblings()[3].value;
         var erinnerungDatum = $(this).siblings()[4].value;
         var erinnerung = $(this).siblings()[5].value;
         var notiz = $(this).siblings()[6].value;
         var taskart = $(this).siblings()[7].value;

         $('#editTaskModal').find('#TaskName').val(name);
         $('#editTaskModal').find('#TaskArt').val(taskart);
         $('#editTaskModal').find('#Spalte').val(spalte);
         $('#editTaskModal').find('#ZustaendigePerson').val(person);
         $('#editTaskModal').find('#erinnerungsdatum').val(erinnerungDatum);
         if(erinnerung == '1') {
             $('#editTaskModal').find('#erinnerung').attr('checked', '');
         } else {
             $('#editTaskModal').find('#erinnerung').removeAttr('checked');
         }
         $('#editTaskModal').find('#erinnerungCheckbox').prop('checked', true);
         $('#editTaskModal').find('#Notizen').val(notiz);
         $('#editTaskModal').find('form').attr('action', '<?= base_url('tasks/bearbeiten/') ?>'+id);

     });

     // $('#erinnerungCheckbox').on('change', function() {
     //     if ($(this).is(':checked')) {
     //         $('#erinnerung').val(1);
     //     } else {
     //         $('#erinnerung').val(0);
     //     }
     // });

     // function updateCheckboxState() {
     //     var erinnerungValue = $('#erinnerung').val();
     //     console.log(erinnerungValue);
     //     if (erinnerungValue == '1') {
     //         console.log(erinnerungValue + " if");
     //         $('#erinnerungCheckbox').prop('checked', true);
     //     } else {
     //         console.log(erinnerungValue + " else");
     //         $('#erinnerungCheckbox').prop('checked', false);
     //     }
     // }

     // i want to make an event listener such that when the checkbox with the ID erinnerung is checked, the date input is enabled
        // and when it is unchecked, the date input is disabled
        // $('#editTaskModal').find('#erinnerung').on('change', function() {
        //     if ($(this).is(':checked')) {
        //         $('#editTaskModal').find('#erinnerungsdatum').prop('disabled', false);
        //     } else {
        //         $('#editTaskModal').find('#erinnerungsdatum').prop('disabled', true);
        //     }


     // Get all delete buttons
     $('.deleteTaskButton').on('click', function() {
         var taskId = $(this).data('task-id');
         var taskName = $(this).data('task-name');

         $('#deleteTaskForm').attr('action', `<?php echo base_url('/tasks/loeschen/'); ?>${taskId}`);
         $('#deleteModalLabel').text(`Willst du die Task "${taskName}" wirklich löschen?`);
     });
 </script>
<?= $this->endSection() ?>