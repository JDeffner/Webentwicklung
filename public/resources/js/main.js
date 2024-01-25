
// Form Validation using AJAX
var request;

$(document).ready(function () {
    $('.crudForm').submit(function (e) {
        e.preventDefault();

        if (request) {
            request.abort();
        }

        var thisForm = $(this);

        // Let's select and cache all the fields
        var formInputElements = thisForm.find("input, select, button, textarea");

        // Serialize the data in the form
        var serializedFormData = thisForm.serialize();

        // Let's disable the inputs for the duration of the Ajax request.
        // Note: we disable elements AFTER the form data has been serialized.
        // Disabled form elements will not be serialized.

        // remove already disabled elements from formInputElements
        formInputElements = formInputElements.filter(function() {
            return !$(this).attr("disabled");
        });

        formInputElements.attr("disabled", "");

        // Remove existing validation error messages
        thisForm.find('.invalid-feedback').remove();
        thisForm.find('.is-invalid').removeClass('is-invalid');

        // Fire off the request
        request = $.ajax({
            url: thisForm.data('send-to'),
            type: "post",
            data: serializedFormData
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            resultingData = JSON.parse(response);
            if (resultingData['successfulValidation']) {
                location.reload();
            } else {
                let errors = Object.entries(resultingData['error']);
                formInputElements.each(function() {
                    let input = $(this);

                    errors.forEach(error => {
                        if (input.attr('id') === error[0]) {
                            input.addClass('is-invalid');
                            let errorElement = document.createElement('div');
                            errorElement.classList.add('invalid-feedback');
                            errorElement.innerText = error[1];
                            errorElement.classList.add('customFeedback');
                            input.parent().append(errorElement);
                        }
                    });
                });
            }
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            // console.error(
            //     "Your request failed\nThe following error occurred: "+
            //     textStatus, errorThrown
            // );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            formInputElements.prop("disabled", false);
        });

    });
});

function Taskartupdate(id, taskartenicon, taskart) {
    taskartenid = id;
    // look for an element with a value of name="taskartenid"
    $('input[name="taskartenid"]').val(taskartenid);

    $("#btnTaskart span").html('<i class="' + taskartenicon + '"></i>' + ' ' + taskart);
}
$(document).ready(function () {
    $('.userForm').submit(function (e) {
        e.preventDefault();

        if (request) {
            request.abort();
        }

        var thisForm = $(this);

        // Let's select and cache all the fields
        var formInputElements = thisForm.find("input, select, button, textarea");

        // Serialize the data in the form
        var serializedFormData = thisForm.serialize();

        // Let's disable the inputs for the duration of the Ajax request.
        // Note: we disable elements AFTER the form data has been serialized.
        // Disabled form elements will not be serialized.

        // remove already disabled elements from formInputElements
        formInputElements = formInputElements.filter(function() {
            return !$(this).attr("disabled");
        });

        formInputElements.attr("disabled", "");

        // Remove existing validation error messages
        thisForm.find('.invalid-feedback').remove();
        thisForm.find('.is-invalid').removeClass('is-invalid');

        // Fire off the request
        request = $.ajax({
            url: thisForm.data('send-to'),
            type: "post",
            data: serializedFormData
        });

        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            resultingData = JSON.parse(response);
            if (resultingData['successfulValidation']) {
                // load the new page
                window.location.href = resultingData['redirect'];
            } else {
                let errors = Object.entries(resultingData['error']);
                formInputElements.each(function() {
                    let input = $(this);

                    errors.forEach(error => {
                        if (input.attr('id') === error[0]) {
                            input.addClass('is-invalid');
                            let errorElement = document.createElement('div');
                            errorElement.classList.add('invalid-feedback');
                            errorElement.innerText = error[1];
                            errorElement.classList.add('customFeedback');
                            input.parent().append(errorElement);
                        }
                    });
                });
            }
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            // console.error(
            //     "Your request failed\nThe following error occurred: "+
            //     textStatus, errorThrown
            // );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            formInputElements.prop("disabled", false);
        });

    });
});


// Create Task Modal
$(document).ready(function () {
    $('.createTaskButton').click(function () {
        var createTaskModal = $('#createTaskModal');
        createTaskModal.find('#createTaskModalLabel').text('Neue Task erstellen');
        createTaskModal.find('form').attr('data-send-to', BASE_URL + 'tasks/erstellen');
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
        editTaskModal.find('#editTaskModalLabel').text('Task "' + name + '" bearbeiten');
        editTaskModal.find('form').attr('data-send-to', BASE_URL + 'tasks/bearbeiten/'+id);

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

        $('#deleteTaskForm').attr('action', BASE_URL + `tasks/loeschen/${boardId}/${taskId}`);
        $('#deleteTaskModalLabel').text(`Willst du die Task "${taskName}" wirklich löschen?`);
    });
});

// Create Spalte
$(document).on('click', '.createSpalteButton', function () {
    var createSpalteModal = $('#createSpalteModal');
    createSpalteModal.find('#createSpalteModalLabel').text('Neue Spalte erstellen');
    createSpalteModal.find('form').attr('data-send-to', BASE_URL + 'spalten/erstellen');
});

// Edit Spalte
$(document).on('click', '.editSpalteButton', function () {
    var id = $(this).data('id');
    var boardsid = $(this).data('boardsid');
    var sortid = $(this).data('sortid');
    var spalte = $(this).data('spalte');
    var spaltenbeschreibung = $(this).data('spaltenbeschreibung');
    var editSpalteModal = $('#editSpalteModal');
    editSpalteModal.find('#editModalLabel').text('Spalte "' + spalte + '" bearbeiten');
    editSpalteModal.find('#spalte').val(spalte);
    editSpalteModal.find('#spaltenbeschreibung').val(spaltenbeschreibung);
    editSpalteModal.find('#sortid').val(sortid);
    editSpalteModal.find('#boardsid').val(boardsid);
    editSpalteModal.find('form').attr('data-send-to', BASE_URL + 'spalten/bearbeiten/' + id);
});

function spaltenAjaxRequest(params) {
    $.ajax({
        url: BASE_URL + 'spalten/raw',
        type: 'get',
        dataType: 'json',
        success: function (response) {
        response.spalten.forEach(function(spalte) {
            spalte.bearbeiten = `<i class="fa-solid fa-pen-to-square editSpalteButton" data-bs-toggle="modal" data-bs-target="#editSpalteModal" data-id="${spalte.id}" data-spalte="${spalte.spalte}" data-spaltenbeschreibung="${spalte.spaltenbeschreibung}" data-board="${spalte.board}" data-boardsid="${spalte.boardsid}" data-sortid="${spalte.sortid}"></i>
                                <i class="fa-solid fa-trash deleteSpalteButton" data-bs-toggle="modal" data-bs-target="#deleteSpalteModal" data-id="${spalte.id}" data-spalte="${spalte.spalte}"></i>`;
        });
        params.success({
            total: response.spalten.length,
            rows:  response.spalten
        })
    }
})
}

// Delete Spalte
$(document).on('click', '.deleteSpalteButton', function () {
    var id = $(this).data('id');
    var spalte = $(this).data('spalte');
    $('#deleteSpalteModalLabel').text('Wollen Sie die Spalte "' + spalte + '" wirklich löschen?');
    $('#deleteSpalteForm').attr('data-delete-at', BASE_URL + 'spalten/loeschen/' + id);
});

// Delete Spalte ajax
$(document).on('submit', '#deleteSpalteForm', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).attr('data-delete-at'),
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            $('.alert').remove();
            if (response.successfulValidation) {
                $('#deleteSpalteModal').modal('hide');
                $('#spaltenTable').bootstrapTable('refresh');
            } else {
                $('#deleteSpalteModal').modal('hide');
                // Create a Bootstrap alert dynamically
                var alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                var closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                var messageDiv = $('<div></div>').text(response.error.deletion);
                alertDiv.append(messageDiv);
                alertDiv.append(closeButton);
                // Append the alert above the buttons
                $('#spalten-table-toolbar').before(alertDiv);
            }
        }
    });
});

function boardsAjaxRequest(params) {
    $.ajax({
        url: BASE_URL + 'boards/raw',
        type: 'get',
        dataType: 'json',
        success: function (response) {

        response.boards.forEach(function(board) {
            board.bearbeiten = `<i class="fa-solid fa-pen-to-square editBoardButton" data-bs-toggle="modal" data-bs-target="#editBoardModal" data-id="${board.id}" data-board="${board.board}"></i>
                                    <i class="fa-solid fa-trash deleteBoardButton" data-bs-toggle="modal" data-bs-target="#deleteBoardModal" data-id="${board.id}" data-board="${board.board}"></i>`;
        });
        params.success({
            total: response.boards.length,
            rows:  response.boards
        })
    }
})
}

// Create Board
$(document).on('click', '.createBoardButton', function () {
    var createBoardModal = $('#createBoardModal');
    createBoardModal.find('#createBoardModalLabel').text('Neues Board erstellen');
    createBoardModal.find('.crudForm').attr('data-send-to', BASE_URL + 'boards/erstellen');
});


// Edit Board
$(document).on('click', '.editBoardButton', function () {
    var id = $(this).data('id');
    var board = $(this).data('board');
    var editBoardModal = $('#editBoardModal');
    editBoardModal.find('#board').val(board);
    editBoardModal.find('#editBoardModalLabel').text('Board "' + board + '" bearbeiten');
    editBoardModal.find('.crudForm').attr('data-send-to', BASE_URL + 'boards/bearbeiten/' + id);
});

// Delete Board
$(document).on('click', '.deleteBoardButton', function () {
    var id = $(this).data('id');
    var board = $(this).data('board');
    $('#deleteBoardModalLabel').text('Wollen Sie das Board "' + board + '" wirklich löschen?');
    $('#deleteBoardForm').attr('data-delete-at', BASE_URL + 'boards/loeschen/' + id);
});

// Delete Board ajax
$(document).on('submit', '#deleteBoardForm', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).attr('data-delete-at'),
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            $('.alert').remove();
            if (response.successfulValidation) {
                $('#deleteBoardModal').modal('hide');
                $('#boardsTable').bootstrapTable('refresh');
            } else {
                $('#deleteBoardModal').modal('hide');
                // Create a Bootstrap alert dynamically
                var alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                var closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                var messageDiv = $('<div></div>').text(response.error.deletion);
                alertDiv.append(messageDiv);
                alertDiv.append(closeButton);
                // Append the alert above the buttons
                $('#boards-table-toolbar').before(alertDiv);
            }
        }
    });
});