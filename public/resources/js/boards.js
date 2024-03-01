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
                board.bearbeiten = `<i class="fas fa-solid fa-copy iconClickable copyBoardButton" data-id="${board.id}" data-board="${board.board}" data-bs-target="#copyBoardModal" data-bs-toggle="modal" title="Board kopieren"></i>
                                    <i class="fa-solid fa-pen-to-square iconClickable editBoardButton" data-bs-toggle="modal" data-bs-target="#editBoardModal" data-id="${board.id}" data-board="${board.board}" title="Board bearbeiten"></i>
                                    <i class="fa-solid fa-trash iconClickable deleteBoardButton" data-bs-toggle="modal" data-bs-target="#deleteBoardModal" data-id="${board.id}" data-board="${board.board}" title="Board löschen"></i>`;
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
                showToast(response.tableName, response.action);
                $('#deleteBoardModal').modal('hide');
                $('#boardsTable').bootstrapTable('refresh');
            } else {
                $('#deleteBoardModal').modal('hide');
                // Create a Bootstrap alert dynamically
                $('#boardsTable').before(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${response.error.deletion}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);

            }
        }
    });
});