<?= $this->extend('layouts/BlankLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h4>Bitte Melden Sie sich an</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo base_url();?>logIn">
                        <div class="form-floating mb-4 mt-1">
                            <input type="email" class="form-control" id="Mail" placeholder="name@example.com">
                            <label for="Mail" class="col-form-label">E-Mail</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="PW" placeholder="Password">
                            <label for="PW" class="col-form-label">Password</label>
                        </div>
                        <div class="justify-content-between align-items-center d-flex">
                            <button type="submit" class="btn btn-success mb-4">Anmelden</button>
                            <a role="button" class="btn btn-secondary mb-4" href="<?php echo base_url('/tasks');?>">Als Gast fortfahren</a>
                        </div>
                    </form>
                    <a href="<?php echo base_url('/newUser');?>">Ich will einen neuen Account erstellen</a>
                </div>
            </div>
        </div>
 </main>
<?= $this->endSection() ?>