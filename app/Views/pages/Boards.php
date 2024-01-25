<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Boards</h4>
        </div>
        <div class="card-body">
            <div class="d-flex" id="table-toolbar">
                <a role="button" class="btn btn-primary mb-2 me-1 createBoardButton" data-bs-toggle="modal" data-bs-target="#createBoardModal"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>
                <div class="buttons-toolbar"></div>
            </div>

            <table class="table table-hover table-bordered table-responsive"
                   id="table"
                   data-toggle="table"
                   data-height="460"
                   data-ajax="boardAjaxRequest"
                   data-search="true"
                   data-pagination="true"
                   data-buttons-toolbar=".buttons-toolbar">
                <thead>
                    <tr>
                        <th scope="col" data-sortable="true" data-field="id">ID</th>
                        <th scope="col" data-sortable="true" data-field="board">Board</th>
                        <th scope="col" data-field="bearbeiten">Bearbeiten</th>
                    </tr>
                </thead>
            </table>
    </div>
    </div>
</main>

<!-- Create Board Modal -->
<div class="modal fade" id="createBoardModal" tabindex="-1" aria-labelledby="createBoardModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Neues Board erstellen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                include APPPATH . 'Views/components/BoardForm.php';
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Edit Board Modal -->
<div class="modal fade" id="editBoardModal" tabindex="-1" aria-labelledby="editBoardModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Board bearbeiten</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                include APPPATH . 'Views/components/BoardForm.php';
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Deletion Modal -->
<div class="modal fade" id="deletionBoardModal" tabindex="-1" aria-labelledby="deletionBoardModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                <form id="deleteBoardForm" data-delete-at="place url here">
                    <button type="submit" class="btn btn-warning delete-task-btn">Board löschen</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function boardAjaxRequest(params) {
        $.ajax({
            url: '<?= base_url('boards/raw') ?>',
            type: 'get',
            dataType: 'json',
            success: function (response) {

                response.boards.forEach(function(board) {
                    board.bearbeiten = `<i class="fa-solid fa-pen-to-square editBoardButton" data-bs-toggle="modal" data-bs-target="#editBoardModal" data-id="${board.id}" data-board="${board.board}"></i>
                                    <i class="fa-solid fa-trash deleteBoardButton" data-bs-toggle="modal" data-bs-target="#deletionBoardModal" data-id="${board.id}" data-board="${board.board}"></i>`;
                });
                params.success({
                    total: response.boards.length,
                    rows:  response.boards
                })
            }
        })
    }

    $(document).ready(function () {
        // Create Board
        $('.createBoardButton').click(function () {
            // AJAX request to create a board
            $('#createBoardModal').find('.crudForm').attr('data-send-to', '<?= base_url('boards/erstellen') ?>');
        });

    });

    // Edit Board
    $(document).on('click', '.editBoardButton', function () {
        // AJAX request to update a board
        var id = $(this).data('id');
        var board = $(this).data('board');
        $('#editBoardModal').find('#board').val(board);
        $('#editBoardModal').find('.crudForm').attr('data-send-to', '<?= base_url('boards/bearbeiten/') ?>' + id);
    });

    // Delete Board
    $(document).on('click', '.deleteBoardButton', function () {
        // AJAX request to delete a board
        var id = $(this).data('id');
        var board = $(this).data('board');
        $('#deleteModalLabel').text('Wollen Sie das Board "' + board + '" wirklich löschen?');
        $('#deleteBoardForm').attr('data-delete-at', '<?= base_url('boards/loeschen/') ?>' + id);
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
                    $('#deletionBoardModal').modal('hide');
                    $('#table').bootstrapTable('refresh');
                } else {
                    $('#deletionBoardModal').modal('hide');
                    // Create a Bootstrap alert dynamically
                    var alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                    var closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                    var messageDiv = $('<div></div>').text(response.error.deletion);
                    alertDiv.append(messageDiv);
                    alertDiv.append(closeButton);
                    // Append the alert above the buttons
                    $('#table-toolbar').before(alertDiv);
                }
            }
        });
    });



</script>
<?= $this->endSection() ?>
