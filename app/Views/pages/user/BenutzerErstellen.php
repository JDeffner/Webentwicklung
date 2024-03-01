<?= $this->extend('layouts/BlankLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h3 class="mb-5">Neuen Account Erstellen</h3>
                        <form class="minMaxForm" data-send-to="<?php echo base_url();?>benutzer/erstellen">
                            <div class="form-floating mb-4 mt-1">
                                <input type="text" class="form-control form-control-lg" id="vorname" placeholder="Vorname" name="vorname">
                                <label for="vorname" class="col-form-label">Vorname</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control form-control-lg" id="nachname" placeholder="Nachname" name="nachname">
                                <label for="nachname" class="col-form-label">Nachname</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control form-control-lg" id="email" placeholder="name@example.com" name="email">
                                <label for="email" class="col-form-label">E-Mail</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control form-control-lg" id="passwort" placeholder="Passwort" name="passwort">
                                <label for="passwort" class="col-form-label">Passwort</label>
                            </div>

                            <button type="submit" class="btn btn-success mb-2">Speichern</button>
                            <a role="button" class="btn btn-secondary mb-2" href="<?php echo base_url('/');?>">Abbrechen</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </main>
<?= $this->endSection() ?>