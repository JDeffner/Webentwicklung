<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="card ms-3 me-3 col-sm-8">
        <div class="card-header">
            <h4>Neue Task erstellen oder bearbeiten</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php
                if(isset($id))
                    echo base_url('tasks/bearbeiten/'.$id);
                    else echo base_url('tasks/erstellen');?>">
                <div class="mb-3 row">
                    <label for="TaskName" class="col-sm-2 col-form-label">Name der Task:</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-end" id="TaskName" placeholder="Bezeichnung der Task..." name="tasks">
<!--                            <div class="dropdown ms-2">-->
<!--                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" name="taskartenid">-->
<!--                                    1-->
<!--                                </button>-->
<!--                                <ul class="dropdown-menu dropdown-menu-end">-->
<!--                                    <li><button class="dropdown-item" type="button">Option 1</button></li>-->
<!--                                    <li><button class="dropdown-item" type="button">Option 2</button></li>-->
<!--                                    <li><button class="dropdown-item" type="button">Option 3</button></li>-->
<!--                                </ul>-->
<!--                            </div>-->
                            <select class="form-select ms-2 rounded-start" id="TaskArt" name="taskartenid">
                                <?php foreach (($taskarten ?? null) as $taskart): ?>
                                    <option value="<?= $taskart['id'] ?>"><?= $taskart['taskart'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                </div>


                <div class="mb-3 row">
                    <label for="BoardSpalte" class="col-sm-2 col-form-label">Board & Spalte:</label>
                    <div class="col-sm-10">
<!--                        // databank access-->
                        <select class="form-select" id="Spalte" name="spaltenid">
                            <option selected>Board und Spalte auswählen</option>
                            <?php foreach (($spalten ?? null) as $spalte): ?>
                                <?php foreach (($boards ?? null) as $board): ?>
                                    <?php if ($spalte['boardsid'] == $board['id']): ?>
                                        <option value="<?= $spalte['id'] ?>"><?= $board['board'] . ' - ' . $spalte['spalte'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="ZustaendigePerson" class="col-sm-2 col-form-label">Zugeteilt an:</label>
                    <div class="col-sm-10">
                        <!--                        // databank access-->
                        <select class="form-select" id="ZustaendigePerson" name="personenid">
                            <option selected>Person auswählen</option>
                            <?php foreach (($personen ?? null) as $item): ?>
                                <option value="<?= $item["id"] ?>"><?= $item["vorname"] ?> <?= $item["nachname"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="erinnerungsdatum" class="col-sm-2 col-form-label">Erinnerung:</label>
                    <div class="col input-group">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" value="1" aria-label="Checkbox for following text input" name="erinnerung">
                        </div>

                        <!--                        <span class="input-group-text">am</span>-->
                        <input type="datetime-local" data-provide="datepicker" class="form-control" id="erinnerungsdatum"
                               placeholder="Datum" name="erinnerungsdatum"
                                data-np-intersection-state="observed" value="<?php echo date('Y-m-d\TH:i', strtotime('+1 hour')); ?>">

                    </div>
                </div>


                <div class="mb-3 row">
                    <label for="Notizen" class="col-sm-2 col-form-label ">Notizen:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="Notizen" style="height: 5em" placeholder="Notizen..." name="notizen"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mb-2">Speichern</button>
                <a role="button" class="btn btn-secondary mb-2" href="<?php echo base_url('/tasks');?>">Abbrechen</a>
            </form>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>