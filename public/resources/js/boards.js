/* Available variables:
const BASE_URL     Declared in head.php
let formRequest    Declared in main.js
 */
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