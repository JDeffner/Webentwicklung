<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container-fluid">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h4>Tasks</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url();?>newUser">
                <div class="mb-3 row">
                    <label for="Vorname" class="col-sm-2 col-form-label">Benutzername</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Vorname" placeholder="Benutzername">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="Nachname" class="col-sm-2 col-form-label">Nachname</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Nachname" placeholder="Nachname">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="Mail" class="col-sm-2 col-form-label">E-Mail</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="Mail" placeholder="E-Mail">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="PW" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="PW" placeholder="Password">
                    </div>
                </div>
                <button type="submit" class="btn btn-success mb-3">Speichern</button>
                <a role="button" class="btn btn-secondary mb-3" href="<?php echo base_url('/');?>">Abbrechen</a>
            </form>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>