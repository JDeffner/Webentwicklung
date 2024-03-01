<?= $this->extend('layouts/BlankLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <h3 class="mb-5">Login</h3>

                        <form class="minMaxForm" data-send-to="<?php echo base_url();?>benutzer/anmelden">
                            <div class="form-floating mb-4 mt-1">
                                <input type="email" id="email" class="form-control form-control-lg" placeholder="name@example.com" name="email"/>
                                <label class="form-label" for="email">E-mail</label>
                            </div>

                            <div class="form-floating mb-5">
                                <input type="password" id="passwort" class="form-control form-control-lg" placeholder="Passwort" name="passwort"/>
                                <label class="form-label" for="passwort">Passwort</label>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Anmelden</button>
                            <div class="my-2">
                                oder
                            </div>
                            <a role="button" class="btn btn-secondary mb-4 w-100" href="<?php echo base_url('benutzer/erstellen');?>">Neuen Account erstellen</a>

                        </form>

                        <hr class="my-4">

                        <a href="<?php echo base_url('benutzer/gast');?>">Als Gast fortfahren</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>
