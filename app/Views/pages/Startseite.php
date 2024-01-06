<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container">
    <div class="card">
        <div class="card-header">
            <h4>Bitte Melden Sie sich an</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo base_url();?>logIn">
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="Mail" placeholder="name@example.com">
                    <label for="Mail" class="col-sm-2 col-form-label">E-Mail</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="PW" placeholder="Password">
                    <label for="PW" class="col-sm-2 col-form-label">Password</label>
                </div>
                <button type="submit" class="btn btn-success mb-4">Speichern</button>
                <a role="button" class="btn btn-secondary mb-4" href="<?php echo base_url('/tasks');?>">Als Gast fortfahren</a>
            </form>
            <a href="<?php echo base_url('/newUser');?>">Ich will einen neuen Account erstellen</a>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>