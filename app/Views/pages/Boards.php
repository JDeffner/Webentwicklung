<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Boards</h4>
        </div>
        <div class="card-body">
            <div class="d-flex" id="boards-table-toolbar">
                <a role="button" class="btn btn-primary mb-2 me-1 createBoardButton" data-bs-toggle="modal" data-bs-target="#createBoardModal"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>
                <div class="boards-buttons-toolbar"></div>
            </div>

            <table class="table table-hover table-bordered table-responsive"
                   id="boardsTable"
                   data-toggle="table"
                   data-height="460"
                   data-ajax="boardsAjaxRequest"
                   data-search="true"
                   data-pagination="true"
                   data-buttons-toolbar=".boards-buttons-toolbar">
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
<?= view_cell('CrudModals::createModal', 'type=Board') ?>

<!-- Edit Board Modal -->
<?= view_cell('CrudModals::editModal','type=Board') ?>

<!-- Deletion Modal -->
<?= view_cell('CrudModals::deleteModal','type=Board') ?>

<script>
    function boardsAjaxRequest(params) {
        $.ajax({
            url: '<?= base_url('boards/raw') ?>',
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
        createBoardModal.find('.crudForm').attr('data-send-to', '<?= base_url('boards/erstellen') ?>');
    });


    // Edit Board
    $(document).on('click', '.editBoardButton', function () {
        var id = $(this).data('id');
        var board = $(this).data('board');
        var editBoardModal = $('#editBoardModal');
        editBoardModal.find('#board').val(board);
        editBoardModal.find('#editBoardModalLabel').text('Board "' + board + '" bearbeiten');
        editBoardModal.find('.crudForm').attr('data-send-to', '<?= base_url('boards/bearbeiten/') ?>' + id);
    });

    // Delete Board
    $(document).on('click', '.deleteBoardButton', function () {
        var id = $(this).data('id');
        var board = $(this).data('board');
        $('#deleteBoardModalLabel').text('Wollen Sie das Board "' + board + '" wirklich löschen?');
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



</script>
<?= $this->endSection() ?>
