function tasksAjaxRequest(params) {
    $.ajax({
        url: BASE_URL + 'tasks/raw',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            response.tasks.forEach(function(task) {
                task.bearbeiten = `<i class="fa-solid fa-pen-to-square editTaskButton" data-bs-toggle="modal" data-bs-target="#editTaskModal" 
                                data-task="${task.task}" data-taskartenid="${task.taskartenid}" data-taskartenicon="${task.taskartenicon}" 
                                data-taskart="${task.taskart}" data-spaltenid="${task.spaltenid}" data-personenid="${task.personenid}" 
                                data-erinnerungsdatum="${task.erinnerungsdatum}" data-erinnerung="${task.erinnerung}" data-notizen="${task.notizen}" 
                                data-id="${task.id}"></i>
                                <i class="fa-solid fa-trash deleteTaskButton" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" 
                                data-id="${task.id}" data-task="${task.task}"></i>`;
            });
            params.success({
                total: response.tasks.length,
                rows:  response.tasks
            })
        }
    })
}


function reloadTaskBoard(currentBoardID) {
    $('#tasksTable').bootstrapTable('refresh')
}


$('.form-check-input').on('change', function() {

    if ($(this).prop('checked')) {
        $('.erinnerungsdatum').removeAttr('disabled');
    } else {

        $('.erinnerungsdatum').attr('disabled', '');
    }
});