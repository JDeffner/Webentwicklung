
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