<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
  <div class="card col-sm-10">
    <div class="card-header">
      <h4>Spalte erstellen</h4>
    </div>
    <div class="card-body">
        <div class="mb-3 row">
          <label for="Spaltenbezeichnung" class="col-sm-2 col-form-label">Spalten-bezeichnung:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="Spaltenbezeichnung" placeholder="Bezeichnung für Spalte">
          </div>
        </div>

        <div class="mb-3 row">
          <label for="Spaltenbeschreibung" class="col-sm-2 col-form-label ">Spaltenbeschreibung:</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="Spaltenbeschreibung" style="height: 11em"></textarea>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="Sortid" class="col-sm-2 col-form-label">Sortid:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="Sortid" placeholder="Sortid angeben">
          </div>
        </div>

        <div class="mb-3 row">
          <label for="BoardAuswaehlen" class="col-sm-2 col-form-label">Board auswählen:</label>
          <div class="col-sm-10">
            <select class="form-select" id="BoardAuswaehlen">
              <option selected>Allgemeine Todos</option>
              <option value="1">Wichtige Todos</option>
              <option value="2">Unwichtige Todos</option>
              <option value="3">Erledigte Todos??!</option>
            </select>
          </div>
        </div>
        <a role="button" class="btn btn-success mb-3" href="<?php echo base_url('/spalten');?>">Speichern</a>
        <a role="button" class="btn btn-secondary mb-3" href="<?php echo base_url('/spalten');?>">Abbrechen</a>
    </div>
  </div>
</main>
<?= $this->endSection() ?>
