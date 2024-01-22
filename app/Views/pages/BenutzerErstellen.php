<?= $this->extend('layouts/BlankLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="card ms-3 me-3 col-sm-8">
        <div class="card-header">
            <h4>Neuen Account Erstellen</h4>
        </div>
        <div class="card-body">
            <form class="userForm" data-send-to="<?php echo base_url();?>benutzer/erstellen">
                <div class="form-floating mb-4 mt-1">
                    <input type="text" class="form-control" id="vorname" placeholder="Vorname" name="vorname">
                    <label for="vorname" class="col-form-label">Vorname</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="text" class="form-control" id="nachname" placeholder="Nachname" name="nachname">
                    <label for="nachname" class="col-form-label">Nachname</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
                    <label for="email" class="col-form-label">E-Mail</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="passwort" placeholder="Passwort" name="passwort">
                    <label for="passwort" class="col-form-label">Passwort</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="passwortWiederholen" placeholder="Passwort wiederholen" name="passwortWiederholen">
                    <label for="passwortWiederholen" class="col-form-label">Passwort wiederholen</label>
                </div>
                <button type="submit" class="btn btn-success mb-2">Speichern</button>
                <a role="button" class="btn btn-secondary mb-2" href="<?php echo base_url('/');?>">Abbrechen</a>
            </form>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>