let baseurl = 'https://team04.wi1cm.uni-trier.de/public/';

// Path: public/resources/js/main.js
// $(document).ready(function() {
//     $('.delete-task-btn').on('click', function() {
//         var taskId = $(this).data('task-id');
//         console.log('Task ID:', taskId);
//         $('#deleteTaskForm').attr('action', '<?php echo base_url('/tasks/loeschen/'); ?>' + taskId);
//     });
// });


// Get all edit buttons
const editButtons = document.querySelectorAll('.fa-pen-to-square');

editButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Get the task data from the data attributes
        const taskData = {
            tasks: this.getAttribute('data-task-name'),
            personenid: this.getAttribute('data-task-person'),
            spaltenid: this.getAttribute('data-task-spalte'),
            taskartenid: this.getAttribute('data-task-taskart'),
            erinnerungsdatum: this.getAttribute('data-task-erinnerung-datum'),
            notizen: this.getAttribute('data-task-notiz'),
            erinnerung: this.getAttribute('data-task-erinnerung') === '1'
        };

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