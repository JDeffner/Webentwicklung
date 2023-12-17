<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Spalte erstellen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../public/main.css">
  <script src="https://unpkg.com/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>



<header>
  <nav class="navbar navbar-expand-md mb-4 ps-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="../../../public/resources/images/WE_Logo.svg" alt="logo.svg" height="60">
      </a>

      <button class="navbar-toggler custom-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDropdown"
              aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbarDropdown">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Boards</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="Spalten.php">Spalten</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>


<main class="container">
  <div class="card">
    <div class="card-header">
      <h4>Spalte erstellen</h4>
    </div>
    <div class="list-group list-group-flush">
      <div class="list-group-item">

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





        <a role="button" class="btn btn-success mb-3" href="Spalten.php">Speichern</a>
        <a role="button" class="btn btn-secondary mb-3" href="Spalten.php">Abbrechen</a>
      </div>

    </div>
  </div>
</main>




  <footer>
    <div class="container pt-5 pb-4">
      <div class="row">
        <div class="col-md-4">
          © Web-Entwicklung Team 2023
        </div>

        <div class="col-md-auto ms-md-auto">
          <p class="text-end">
            Impressum
          </p>
        </div>
        <div class="col-md-auto">
          <p class="text-end">
            Datenschutz
          </p>
        </div>
        <div class="col-md-auto">
          <p class="text-end">
            Kontakt
          </p>
        </div>
      </div>
    </div>
  </footer>


</body>
</html>