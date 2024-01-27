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
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $boardName ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php foreach (($boards ?? null) as $oneBoard): ?>
                        <li><a class="dropdown-item" href="<?= base_url('tasks/').$oneBoard['id'] ?>"><?= $oneBoard['board'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card-body">


            <div class="d-flex flex-row flex-nowrap overflow-auto prettyScrollbar" id="tasksBoard">
                <?php foreach (($spaltenForBoard ?? null) as $oneSpalte): ?>
                    <div class="me-3">
                        <div class="card">
                            <div class="card-header">
                                <h3><?= $oneSpalte['spalte'] ?></h3>
                                <small class="mb-0"><?= $oneSpalte['spaltenbeschreibung'] ?></small>
                            </div>
                            <div class="card-body spaltenBody" id="spalte<?= $oneSpalte['id'] ?>">
                                <?php foreach (($tasks ?? null) as $oneTask):
                                if ($oneTask['spaltenid'] == $oneSpalte['id']) { ?>
                                    <?= view_cell('Tasks::singleTask', $oneTask); ?>
                                <?php } endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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

<?= $this->endSection() ?>