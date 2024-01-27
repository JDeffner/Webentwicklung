
// Form Validation using AJAX
let request;

$(document).ready(function () {
    $('.minMaxForm').submit(function (e) {
        e.preventDefault();

        if (request) {
            request.abort();
        }

        const thisForm = $(this);

        // Let's select and cache all the fields
        let formInputElements = thisForm.find("input, select, button, textarea");

        // Serialize the data in the form
        const serializedFormData = thisForm.serialize();

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
            let resultingData = JSON.parse(response);
            if (resultingData['successfulValidation']) {
                if(resultingData['tableName'] === 'tasks') {
                    // location.reload();
                    $('.modal').modal('hide');
                    reloadTaskBoard('1');
                } else if (resultingData['tableName'] === 'personen') {
                    window.location.href = resultingData['redirect'];
                } else {
                    $('.modal').modal('hide');
                    $(`#${resultingData['tableName']}Table`).bootstrapTable('refresh');
                }
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





function handleCrud(typeName, pluralTypeName) {
    // Create
    $(document).on('click', `.create${typeName}Button`, function () {
        const createModal = $(`#create${typeName}Modal`);
        createModal.find(`#create${typeName}ModalLabel`).text(`${typeName} erstellen`);
        createModal.find('.minMaxForm').attr('data-send-to', BASE_URL + `${pluralTypeName.toLowerCase()}/erstellen`);
    });
    // Edit
    $(document).on('click', `.edit${typeName}Button`, function () {

        const typeInstanceName = $(this).data(typeName.toLowerCase());
        const typeInstanceID = $(this).data('id');

        const editModal = $(`#edit${typeName}Modal`);

        // ajax request to get the data
        $.ajax({
            url: BASE_URL + `${pluralTypeName.toLowerCase()}/${typeName.toLowerCase()}/${typeInstanceID}`,
            type: 'post',
            dataType: 'json',
            success: function (response) {
                let tableRow = response[typeName.toLowerCase()];
                for (const column in tableRow) {
                    const value = tableRow[column];
                    switch (column) {
                        case 'taskartenid':
                            editModal.find('#taskartenid').val(value);
                            let taskartenicon = response['taskarten']['taskartenicon'];
                            let taskart = response['taskarten']['taskart'];
                            editModal.find('#btnTaskart span').html('<i class="' + taskartenicon + '"></i>' + ' ' + taskart);
                            break;
                        case 'erinnerung':
                            if (value === '1') {
                                editModal.find('#erinnerung').prop('checked', true)
                                editModal.find('#erinnerungsdatum').removeAttr('disabled');
                            } else {
                                editModal.find('#erinnerung').prop('checked', false)
                                editModal.find('#erinnerungsdatum').attr('disabled', '');
                            }
                            break;
                        default:
                            editModal.find(`#${column}`).val(value);
                    }
                }
            }
        });


        editModal.find(`#edit${typeName}ModalLabel`).text(`"${typeInstanceName}" bearbeiten`);
        editModal.find('.minMaxForm').attr('data-send-to', BASE_URL + `${pluralTypeName.toLowerCase()}/bearbeiten/` + typeInstanceID);
    });

    // Delete
    $(document).on('click', `.delete${typeName}Button`, function () {
        const typeInstanceID = $(this).data('id');
        const typeInstanceName = $(this).data(typeName.toLowerCase());
        $(`#delete${typeName}ModalLabel`).text(`Wollen Sie "${typeInstanceName}" wirklich löschen?`);
        $(`#delete${typeName}Form`).attr('data-delete-at', BASE_URL + `${pluralTypeName.toLowerCase()}/loeschen/` + typeInstanceID);
    });
}

// Call the function for each type
$(document).ready(function () {
    handleCrud('Task', 'Tasks');
    handleCrud('Board', 'Boards');
    handleCrud('Spalte', 'Spalten');
});

// Erinnerung Checkbox disable/enable Erinnerungsdatum
$('.form-check-input').on('change', function() {

    if ($(this).prop('checked')) {
        $('.erinnerungsdatum').removeAttr('disabled');
    } else {

        $('.erinnerungsdatum').attr('disabled', '');
    }
});

// Delete Task ajax
$(document).on('submit', '#deleteTaskForm', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).attr('data-delete-at'),
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            $('.alert').remove();
            if (response.successfulValidation) {
                $('#deleteTaskModal').modal('hide');
                $(`#task${response.taskid}`).remove();
            } else {
                $('#deleteTaskModal').modal('hide');
                // Create a Bootstrap alert dynamically
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                const closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                const messageDiv = $('<div></div>').text(response.error.deletion);
                alertDiv.append(messageDiv);
                alertDiv.append(closeButton);
                // Append the alert above the buttons
                $('#tasks-table-toolbar').before(alertDiv);
            }
        }
    });
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
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                const closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                const messageDiv = $('<div></div>').text(response.error.deletion);
                alertDiv.append(messageDiv);
                alertDiv.append(closeButton);
                // Append the alert above the buttons
                $('#spalten-table-toolbar').before(alertDiv);
            }
        }
    });
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
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                const closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                const messageDiv = $('<div></div>').text(response.error.deletion);
                alertDiv.append(messageDiv);
                alertDiv.append(closeButton);
                // Append the alert above the buttons
                $('#boards-table-toolbar').before(alertDiv);
            }
        }
    });
});