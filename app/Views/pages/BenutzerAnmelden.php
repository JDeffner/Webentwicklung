<?= $this->extend('layouts/BlankLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h4>Bitte Melden Sie sich an</h4>
                </div>
                <div class="card-body">
                    <form class="minMaxForm" data-send-to="<?php echo base_url();?>benutzer/anmelden">
                        <div class="form-floating mb-4 mt-1">
                            <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
                            <label for="email" class="col-form-label">E-Mail</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="passwort" placeholder="Passwort" name="passwort">
                            <label for="passwort" class="col-form-label">Password</label>
                        </div>
                        <div class="justify-content-between align-items-center d-flex">
                            <button type="submit" class="btn btn-success mb-4">Anmelden</button>
                            <a role="button" class="btn btn-secondary mb-4" href="<?php echo base_url('benutzer/gast');?>">Als Gast fortfahren</a>
                        </div>
                    </form>
                    <a href="<?php echo base_url('benutzer/erstellen');?>">Ich will einen neuen Account erstellen</a>
                </div>
            </div>
        </div>
 </main>
<?= $this->endSection() ?>