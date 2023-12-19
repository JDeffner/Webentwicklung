<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container">
  <div class="card">
    <div class="card-header">
      <h4>Spalte erstellen</h4>
    </div>
    <div class="card-body">

        <div class="mb-3 row">
          <label for="Spaltenbezeichnung" class="col-sm-2 col-form-label">Spalten-bezeichnung</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="Spaltenbezeichnung" placeholder="Bezeichnung für Spalte">
          </div>
        </div>

        <div class="mb-3 row">
          <label for="Spaltenbeschreibung" class="col-sm-2 col-form-label ">Spaltenbeschreibung</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="Spaltenbeschreibung" style="height: 22em"></textarea>
          </div>
        </div>

        <div class="mb-3 row">
          <label for="Sortid" class="col-sm-2 col-form-label">Sortid</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="Sortid" placeholder="Sortid angeben">
          </div>
        </div>

        <!--Hier unser alter code: -->
        <!--<div class="mb-3 row">
          <label for="sortid" class="col-sm-2 col-form-label">Board auswählen</label>
          <div class="dropdown col-sm-10">
            <button class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Allgemeine Tools
            </button>
            <ul class="dropdown-menu">
              <li><button class="dropdown-item" type="button">Option 1</button></li>
              <li><button class="dropdown-item" type="button">Option 2</button></li>
              <li><button class="dropdown-item" type="button">Option 3</button></li>
            </ul>
          </div>
        </div>-->

        <!--neuer code für den dropdown button um den text links und den pfeil rechts zu haben-->
        <div class="mb-3 row">
          <label for="BoardAuswaehlen" class="col-sm-2 col-form-label">Board auswählen</label>
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
