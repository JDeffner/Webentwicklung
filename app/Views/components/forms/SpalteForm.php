<form class="minMaxForm" data-send-to="place url here">
    <div class="mb-3">
        <label for="spalte" class="form-label">Name der Spalte:</label>
        <div class="input-group">
            <input type="text" class="form-control rounded-end" id="spalte" placeholder="Bezeichnung der Spalte..." name="spalte" >
        </div>
    </div>

    <div class="mb-3">
        <label for="boardsid" class="form-label">Board:</label>
        <select class="form-select boardSelect" id="boardsid" name="boardsid">
            <option selected>Board auswählen</option>
            <?php foreach (($boards ?? null) as $board): ?>
                <option value="<?= $board['id'] ?>"><?= $board['board'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="mb-3">
        <label for="spaltenbeschreibung" class="form-label">Spaltenbeschreibung:</label>
        <textarea class="form-control" id="spaltenbeschreibung" style="height: 5em" placeholder="Spaltenbeschreibung..." name="spaltenbeschreibung"></textarea>

    </div>

    <div class="mb-3">
        <label for="sortid" class="form-label">Sortid:</label>
        <div class="input-group">
            <input type="number" class="form-control rounded-end" id="sortid" placeholder="Sortid..." name="sortid">
        </div>
    </div>

    <button type="submit" class="btn btn-success mb-2">Speichern</button>
    <button type="button" class="btn btn-secondary mb-2" data-bs-dismiss="modal">Abbrechen</button>
</form>