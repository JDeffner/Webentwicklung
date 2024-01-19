<form method="post" action="<?php echo $formAction; ?>">
    <div class="mb-3">
        <label for="TaskName" class="form-label">Name der Task:</label>
        <div class="input-group">
            <input type="text" class="form-control rounded-end" id="TaskName" placeholder="Bezeichnung der Task..." name="tasks" >
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


    <div class="mb-3">

        <label for="BoardSpalte" class="form-label">Board & Spalte:</label>
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

    <div class="mb-3">
        <label for="ZustaendigePerson" class="form-label">Zugeteilt an:</label>
        <!--                        // databank access-->
        <select class="form-select" id="ZustaendigePerson" name="personenid">
            <option selected>Person auswählen</option>
            <?php foreach (($personen ?? null) as $item): ?>
                <option value="<?= $item["id"] ?>"><?= $item["vorname"] ?> <?= $item["nachname"] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="erinnerungsdatum" class="form-label">Erinnerung:</label>
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


    <div class="mb-3">
        <label for="Notizen" class="form-label ">Notizen:</label>
        <textarea class="form-control" id="Notizen" style="height: 5em" placeholder="Notizen..." name="notizen"></textarea>
    </div>
    <button type="submit" class="btn btn-success mb-2">Speichern</button>
    <a role="button" class="btn btn-secondary mb-2" href="<?php echo base_url('/tasks');?>">Abbrechen</a>
</form>