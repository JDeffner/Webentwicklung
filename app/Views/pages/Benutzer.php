<?= $this->extend('layouts/DefaultLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h3>
                Wilkommen
                <?php if (isset($person['vorname']) && isset($person['nachname'])) {
                    echo $person['vorname']. " " . $person['nachname'];
                } else {
                    echo "Gast";
                } ?>!
            </h3>
        </div>
        <div class="card-body">
            <div class="container text-wrap">
                <h5>
                    <?php if (isset($person['vorname']) && isset($person['nachname'])) {
                        echo "Sie haben sich erfolgreich registriert! Sie können sich nun in tasks eintragen.";
                    } else {
                        echo "Da sie sich nicht registriert haben, können sie sich nicht in tasks eintragen.";
                    } ?>
                </h5>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
