<form class="minMaxForm" data-send-to="place url here">
    <div class="mb-3">
        <label for="task" class="form-label">Name der Task:</label>
        <div class="input-group">
            <input type="text" class="form-control rounded-end" id="task" placeholder="Bezeichnung der Task..." name="task" >
            <input type="hidden" id="taskartenid" name="taskartenid" value="1">
            <button class="btn btn-secondary ms-2 dropdown-toggle rounded" type="button" id="btnTaskart" data-bs-toggle="dropdown" aria-expanded="false">
                <span><i class="fa-solid fa-house-chimney"></i> Besuch</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php foreach (($taskarten ?? null) as $taskart): ?>
                <li>
                <a class="dropdown-item" onclick="Taskartupdate('<?= $taskart['id'] ?>','<?= $taskart['taskartenicon'] ?>','<?= $taskart['taskart'] ?>');"><i class="<?= $taskart['taskartenicon'] ?>"></i> <?= $taskart['taskart'] ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>


    <div class="mb-3">

        <label for="spaltenid" class="form-label">Board & Spalte:</label>
        <!--                        // databank access-->
        <select class="form-select" id="spaltenid" name="spaltenid">
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
        <label for="personenid" class="form-label">Zugeteilt an:</label>
        <!--                        // databank access-->
        <select class="form-select" id="personenid" name="personenid">
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
                <input class="form-check-input mt-0" type="checkbox" value="1" id="erinnerung" aria-label="Checkbox that determines if a reminder is saved" name="erinnerung">
            </div>
            <input type="datetime-local" data-provide="datepicker" class="form-control erinnerungsdatum" id="erinnerungsdatum"
                   placeholder="Datum" name="erinnerungsdatum"
                   data-np-intersection-state="observed" disabled>

        </div>
    </div>


    <div class="mb-3">
        <label for="notizen" class="form-label ">Notizen:</label>
        <textarea class="form-control" id="notizen" style="height: 5em" placeholder="Notizen..." name="notizen"></textarea>
    </div>
    <button type="submit" class="btn btn-success mb-2">Speichern</button>
    <button type="button" class="btn btn-secondary mb-2" data-bs-dismiss="modal">Abbrechen</button>
</form>