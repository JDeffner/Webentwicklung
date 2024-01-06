<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Neuen Account Erstellen</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url();?>newUser">
                <div class="form-floating mb-4 col-sm-10">
                    <input type="text" class="form-control" id="Vorname" placeholder="Vorname">
                    <label for="Vorname" class="col-sm-2 col-form-label">Vorname</label>
                </div>
                <div class="form-floating mb-4 col-sm-10">
                    <input type="text" class="form-control" id="Nachname" placeholder="Nachname">
                    <label for="Nachname" class="col-sm-2 col-form-label">Nachname</label>
                </div>
                <div class="form-floating mb-4 col-sm-10">
                    <input type="email" class="form-control" id="Mail" placeholder="name@example.com">
                    <label for="Mail" class="col-sm-2 col-form-label">E-Mail</label>
                </div>
                <div class="form-floating mb-4 col-sm-10">
                    <input type="password" class="form-control" id="PW" placeholder="Password">
                    <label for="PW" class="col-sm-2 col-form-label">Password</label>
                </div>
                <button type="submit" class="btn btn-success mb-4">Speichern</button>
                <a role="button" class="btn btn-secondary mb-4" href="<?php echo base_url('/');?>">Abbrechen</a>
            </form>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>