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

                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-task-id="<?= $oneTask['id'] ?>" data-task-name="<?= $oneTask['tasks'] ?>">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <i class="fa-solid fa-trash delete-button" data-bs-toggle="modal" data-bs-target="#deletionModal" data-task-id="<?= $oneTask['id'] ?>" data-task-name="<?= $oneTask['tasks'] ?>"></i>

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
                    $formAction = base_url('tasks/bearbeiten');
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




    <script>
        // Get all edit buttons
        const editButtons = document.querySelectorAll('.fa-pen-to-square');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');

                // Fetch the task data from the server
                fetch(`<?php echo base_url('/tasks/getTaskData/'); ?>${taskId}`)
                    .then(response => response.json())
                    .then(taskData => {
                        // Populate the form fields
                        document.querySelector('#editTaskModal #TaskName').value = taskData.tasks;
                        document.querySelector('#editTaskModal #ZustaendigePerson').value = taskData.personenid;
                        document.querySelector('#editTaskModal #Spalte').value = taskData.spaltenid;
                        document.querySelector('#editTaskModal #TaskArt').value = taskData.taskartenid;
                        document.querySelector('#editTaskModal #erinnerungsdatum').value = taskData.erinnerungsdatum;
                        document.querySelector('#editTaskModal #Notizen').value = taskData.notizen;
                        document.querySelector('#editTaskModal input[name="erinnerung"]').checked = taskData.erinnerung;

                        // Show the edit modal
                        const editTaskModal = new bootstrap.Modal(document.querySelector('#editTaskModal'));
                        editTaskModal.show();
                    });
            });
        });
    </script>

    <script>
        // Get all delete buttons
        const deleteButtons = document.querySelectorAll('.delete-button');

        // Add click event listener to each delete button
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the task ID and name from the data-task-id and data-task-name attributes
                const taskId = this.getAttribute('data-task-id');
                const taskName = this.getAttribute('data-task-name');

                // Get the form in the modal and the modal title
                const form = document.querySelector('#deleteTaskForm');
                const modalTitle = document.querySelector('#deleteModalLabel');

                // Set the action of the form and the modal title dynamically
                form.action = `<?php echo base_url('/tasks/loeschen/'); ?>${taskId}`;
                modalTitle.textContent = `Willst du die Task "${taskName}" wirklich löschen?`;
            });
        });
    </script>


 </main>
<?= $this->endSection() ?>