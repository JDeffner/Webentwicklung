<form class="minMaxForm" data-send-to="place url here">
    <div class="mb-3">
        <label for="vorname" class="form-label">Vorname:</label>
        <div class="input-group">
            <input type="text" class="form-control rounded-end" id="vorname" placeholder="Vorname..." name="vorname">
        </div>
    </div>

    <div class="mb-3">
        <label for="nachname" class="form-label">Nachname:</label>
        <div class="input-group">
            <input type="text" class="form-control rounded-end" id="nachname" placeholder="Nachname..." name="nachname">
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <div class="input-group">
            <input type="email" class="form-control rounded-end" id="email" placeholder="Email..." name="email" disabled>
        </div>
    </div>

    <div class="mb-3">
        <label for="permission" class="form-label">Rolle:</label>
        <select class="form-select" id="permission" name="permission">
            <option value="1">Benutzer</option>
            <option value="2">Administrator</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success mb-2">Speichern</button>
    <button type="button" class="btn btn-secondary mb-2" data-bs-dismiss="modal">Abbrechen</button>
</form>