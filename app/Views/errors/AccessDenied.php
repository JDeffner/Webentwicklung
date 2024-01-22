<?= $this->extend('layouts/BlankLayout') ?>

<?= $this->section('content') ?>
<main class="container justify-content-center align-items-center d-flex">
    <div class="card ms-3 me-3">
        <div class="card-header">
            <h3>
                Zugriff Verweigert!
            </h3>
        </div>
        <div class="card-body">
            <div class="container text-wrap">
                <h5>
                    Sie haben keine Berechtigung diese Seite zu sehen!
                </h5>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
