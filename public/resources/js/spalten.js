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
                spalte.bearbeiten = `<i class="fa-solid fa-pen-to-square editSpalteButton" data-bs-toggle="modal" data-bs-target="#editSpalteModal" 
                                data-id="${spalte.id}" data-spalte="${spalte.spalte}" data-spaltenbeschreibung="${spalte.spaltenbeschreibung}" 
                                data-board="${spalte.board}" data-boardsid="${spalte.boardsid}" data-sortid="${spalte.sortid}"></i>
                                <i class="fa-solid fa-trash deleteSpalteButton" data-bs-toggle="modal" data-bs-target="#deleteSpalteModal" 
                                data-id="${spalte.id}" data-spalte="${spalte.spalte}"></i>`;
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