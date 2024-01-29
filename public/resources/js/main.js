
/* Available variables:
const BASE_URL     Declared in head.php
 */
let formRequest;  // current running crud ajax request

// Call functions after DOM is loaded
$(document).ready(function () {
    handleCrud('Task', 'Tasks');
    handleCrud('Board', 'Boards');
    handleCrud('Spalte', 'Spalten');
    handleCrud('Person', 'Personen');
    handleCrud('Taskart', 'Taskarten');
});

$(document).ready(function () {
    $('.minMaxForm').submit(function (e) {
        e.preventDefault();

        if (formRequest) {
            formRequest.abort();
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
        formRequest = $.ajax({
            url: thisForm.data('send-to'),
            type: "post",
            data: serializedFormData
        });

        // Callback handler that will be called on success
        formRequest.done(function (response, textStatus, jqXHR){
            let resultingData = JSON.parse(response);
            if (resultingData['successfulValidation']) {
                switch(resultingData['tableName']) {
                    case 'tasks':
                        $('.modal').modal('hide');
                        let currentBoardID = $('#boardidDropdown').val();
                        reloadTaskBoard(currentBoardID);
                        break;
                    case 'createPersonen':
                        window.location.href = resultingData['redirect'];
                        break;
                    default:
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
        formRequest.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            console.error(
                "Your request failed\nThe following error occurred: "+
                textStatus, errorThrown
            );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        formRequest.always(function () {
            // Reenable the inputs
            formInputElements.prop("disabled", false);
        });

    });
});

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






