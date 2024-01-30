<div class="modal fade" id="<?= $modalAction.$modalType ?>Modal" tabindex="-1" aria-labelledby="<?= $modalAction.$modalType ?>Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="<?= $modalAction.$modalType ?>ModalLabel"><?= $modalMessage ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($modalAction == 'delete') { ?>
                    <form id="delete<?= $modalType ?>Form" data-delete-at="place url here">
                        <button type="submit" class="btn btn-danger delete-task-btn"><?= $modalType ?> löschen</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    </form>
                <?php } else {
                    echo view_cell('Forms::'.$modalType.'Form');
                } ?>
            </div>
        </div>
    </div>
</div>