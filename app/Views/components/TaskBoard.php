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