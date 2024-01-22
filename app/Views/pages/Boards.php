<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Boards</h4>
        </div>
        <div class="card-body">
            <a role="button" class="btn btn-primary mb-2 createBoardButton" data-bs-toggle="modal" data-bs-target="#createBoardModal">Neu</a>

                <table class="table table-hover table-bordered table-responsive rounded-table"
                       id="table"
                       data-toggle="table"
                       data-height="460"
                       data-ajax="ajaxRequest"
                       data-search="true"
                       data-pagination="true">
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
                <form id="deleteBoardForm" method="post" action="">
                    <button type="submit" class="btn btn-warning delete-task-btn">Board löschen</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function ajaxRequest(params) {
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
        $('#deleteBoardForm').attr('action', '<?= base_url('boards/loeschen/') ?>' + id);
    });



</script>
<?= $this->endSection() ?>
