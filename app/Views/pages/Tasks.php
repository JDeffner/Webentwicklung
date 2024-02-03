<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex flex-column flex-sm-row align-items-start align-sm-center">
            <h4>Tasks</h4>
            <a role="button" class="btn btn-secondary createTaskButton ms-auto me-2" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                <i class="fa-solid fa-square-plus" ></i> Neu
            </a>
            <a role="button" class="btn btn-secondary createTaskButton me-2" id="reload">
                <i class="fa-solid fa-rotate-right"></i>
            </a>
            <div class="col-lg-2 col-md-2 col-sm-10 me-2">
                <input type="search" class="form-control " id="suchetasks" name="suchetasks" placeholder="Suchen">
            </div>

            <div class="dropdown">
                <input type="hidden" id="boardidDropdown" value="<?= $boardID ?>">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="boardidDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><?= $boardName ?></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="boardidDropdownButton">
                    <?php foreach (($boards ?? null) as $oneBoard): ?>
                        <li><a class="dropdown-item" onclick="Boardupdate('<?= $oneBoard['id'] ?>','<?= $oneBoard['board'] ?>');"><?= $oneBoard['board'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card-body">


            <div class="d-flex flex-row flex-nowrap overflow-auto custom-scrollbar" id="tasksBoard">

            </div>
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

<?= $this->endSection() ?>