/* Available variables:
const BASE_URL     Declared in head.php
let formRequest    Declared in main.js
 */

function personenAjaxRequest(params) {
    $.ajax({
        url: BASE_URL + 'admin/personen/raw',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            response.personen.forEach(function(person) {
                person.bearbeiten = `<i class="fa-solid fa-pen-to-square editPersonButton" data-bs-toggle="modal" data-bs-target="#editPersonModal" 
                                data-id="${person.id}" data-vorname="${person.vorname}" data-nachname="${person.nachname}" data-person="${person.vorname} ${person.nachname}" data-email="${person.email}" data-permission="${person.permission}"></i>
                                <i class="fa-solid fa-trash deletePersonButton" data-bs-toggle="modal" data-bs-target="#deletePersonModal" 
                                data-id="${person.id}" data-person="${person.vorname} ${person.nachname}"></i>`;
                if (person.permission === '2') {
                    person.permission = 'Administrator';
                } else {
                    person.permission = 'Benutzer';
                }
            });
            params.success({
                total: response.personen.length,
                rows:  response.personen
            })
        }
    })
}

// Delete Person ajax
$(document).on('submit', '#deletePersonForm', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).attr('data-delete-at'),
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            $('.alert').remove();
            if (response.successfulValidation) {
                $('#deletePersonModal').modal('hide');
                $('#personenTable').bootstrapTable('refresh');
            } else {
                $('#deletePersonModal').modal('hide');
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