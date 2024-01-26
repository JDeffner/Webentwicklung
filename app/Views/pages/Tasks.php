<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header d-flex align-items-center">
            <h4>Tasks</h4>
            <div class="dropdown ms-auto">
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
            <a role="button" class="btn btn-primary mb-3 createTaskButton" data-bs-toggle="modal" data-bs-target="#createTaskModal"><i class="fa-solid fa-square-plus" style="color: #ffffff;"></i> Neu</a>

            <?= view_cell('Tasks::taskBoard', ['boardID' => $boardID] ) ?>
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