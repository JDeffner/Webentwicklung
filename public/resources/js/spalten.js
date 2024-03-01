/* Available variables:
const BASE_URL     Declared in head.php
let formRequest    Declared in main.js
 */

function spaltenAjaxRequest(params) {
    $.ajax({
        url: BASE_URL + 'spalten/raw',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            response.spalten.forEach(function(spalte) {
                spalte.bearbeiten = `
                                <i class="fas fa-solid fa-copy iconClickable copySpalteButton" data-id="${spalte.id}" data-spalte="${spalte.spalte}"
                                data-bs-target="#copySpalteModal" data-bs-toggle="modal" title="Spalte kopieren"></i>
                                <i class="fa-solid fa-pen-to-square iconClickable editSpalteButton" data-bs-toggle="modal" data-bs-target="#editSpalteModal" 
                                data-id="${spalte.id}" data-spalte="${spalte.spalte}"
                                title="Spalte bearbeiten"></i>
                                <i class="fa-solid fa-trash iconClickable deleteSpalteButton" data-bs-toggle="modal" data-bs-target="#deleteSpalteModal" 
                                data-id="${spalte.id}" data-spalte="${spalte.spalte}"
                                title="Spalte löschen"></i>`;
            });
            params.success({
                total: response.spalten.length,
                rows:  response.spalten
            })
        }
    })
}

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
            showToast(response.tableName, response.action);
            if (response.successfulValidation) {
                $('#deleteSpalteModal').modal('hide');
                $('#spaltenTable').bootstrapTable('refresh');
            } else {
                $('#deleteSpalteModal').modal('hide');
                // Create a Bootstrap alert dynamically
                // const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                // const closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                // const messageDiv = $('<div></div>').text(response.error.deletion);

                // Append the alert above the buttons
                $('#spaltenTable').before(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${response.error.deletion}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        }
    });
});