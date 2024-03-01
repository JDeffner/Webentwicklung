<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="me-5">Tasks</h4>
            <a role="button" class="btn btn-secondary createSpalteButton ms-auto me-2 flex-nowrap d-flex align-items-center" title="Spalte erstellen" data-bs-toggle="modal" data-bs-target="#createSpalteModal">
                <i class="fa-solid fa-square-plus py-1"></i> <span class="d-none d-md-block ms-2">Spalte</span>
            </a>
            <a role="button" class="btn btn-secondary me-2 notizenButton" title="Notizen anzeigen/verstecken">
                <i class="fa-solid fa-list-ul"></i>
            </a>
            <a role="button" class="btn btn-secondary createTaskButton me-2" id="reload" title="Taskboard neu laden">
                <i class="fa-solid fa-rotate-right"></i>
            </a>
            <div class="me-2" style="width: 20em;">
                <input type="search" class="form-control " id="suchetasks" name="suchetasks" placeholder="Suchen">
            </div>

            <div class="dropdown" title="Board auswählen">
                <input type="hidden" id="boardidDropdown" value="<?= $boardID ?>">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="boardidDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><?= $boardName ?></span>
                </button>
                <ul class="dropdown-menu" id="boardidDropdownMenu">
                    <?php foreach (($boards ?? null) as $oneBoard): ?>
                        <li><a class="dropdown-item" onclick="Boardupdate('<?= $oneBoard['id'] ?>','<?= $oneBoard['board'] ?>');"><?= $oneBoard['board'] ?></a></li>
                    <?php endforeach; ?>
                    <li><a class="dropdown-item d-flex justify-content-center align-items-center py-2 createBoardButton" data-bs-toggle="modal" data-bs-target="#createBoardModal"><i class="fa-solid fa-plus"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body d-flex flex-row flex-nowrap overflow-auto custom-scrollbar" id="tasksBoard">
            <!-- Hier werden die Spalten und Tasks über die reloadTaskBoard() funktion aus tasks.js geladen -->
        </div>
    </div>
</main>

<!-- Create Task Modal -->
<?= view_cell('CrudModals::createModal', 'type=Task') ?>

<!-- Edit Task Modal -->
<?= view_cell('CrudModals::editModal','type=Task') ?>

<!-- Delete Task Modal -->
<?= view_cell('CrudModals::deleteModal','type=Task') ?>

<!-- Copy Task Modal -->
<?= view_cell('CrudModals::copyModal','type=Task') ?>

<!-- Create Spalte Modal -->
<?= view_cell('CrudModals::createModal','type=Spalte') ?>

    <!-- Edit Spalte Modal -->
<?= view_cell('CrudModals::editModal','type=Spalte') ?>

<!-- Create Board Modal -->
<?= view_cell('CrudModals::createModal','type=Board') ?>


<!-- Toast -->
<?= $this->include('components/CrudToast.php') ?>

<?= $this->endSection() ?>