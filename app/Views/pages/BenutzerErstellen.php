<?= $this->extend('layouts/BlankLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="card ms-3 me-3 col-sm-8">
        <div class="card-header">
            <h4>Neuen Account Erstellen</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url();?>benutzer/erstellen">
                <div class="form-floating mb-4 mt-1">
                    <input type="text" class="form-control" id="Vorname" placeholder="Vorname" name="vorname">
                    <label for="Vorname" class="col-form-label">Vorname</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="text" class="form-control" id="Nachname" placeholder="Nachname" name="nachname">
                    <label for="Nachname" class="col-form-label">Nachname</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="Mail" placeholder="name@example.com" name="email">
                    <label for="Mail" class="col-form-label">E-Mail</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="PW" placeholder="Password" name="password">
                    <label for="PW" class="col-form-label">Password</label>
                </div>
                <button type="submit" class="btn btn-success mb-2">Speichern</button>
                <a role="button" class="btn btn-secondary mb-2" href="<?php echo base_url('/');?>">Abbrechen</a>
            </form>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>